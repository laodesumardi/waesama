<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Helpers\SettingsHelper;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get current settings using SettingsHelper
        $settings = SettingsHelper::all();
        
        return view('admin.settings.index', compact('settings'));
    }
    
    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'office_address' => 'required|string|max:500',
            'office_hours' => 'required|string|max:255',
            'max_queue_per_day' => 'required|integer|min:1|max:200',
            'auto_approve_letters' => 'boolean',
            'notification_email' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);
        
        // Store settings using SettingsHelper
        SettingsHelper::updateMultiple($validated);
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
    
    /**
     * Update settings in real-time via AJAX.
     */
    public function updateRealtime(Request $request)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');
            
            // Validate the field and value
            $rules = [
                'site_name' => 'required|string|max:255',
                'site_description' => 'required|string|max:500',
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'required|string|max:20',
                'office_address' => 'required|string|max:500',
                'office_hours' => 'required|string|max:255',
                'max_queue_per_day' => 'required|integer|min:1|max:200',
                'auto_approve_letters' => 'boolean',
                'notification_email' => 'boolean',
                'maintenance_mode' => 'boolean',
            ];
            
            if (!array_key_exists($field, $rules)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field tidak valid.'
                ], 400);
            }
            
            // Validate the value
            $validator = \Validator::make([$field => $value], [$field => $rules[$field]]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first($field)
                ], 422);
            }
            
            // Convert boolean strings to actual booleans
            if (in_array($field, ['auto_approve_letters', 'notification_email', 'maintenance_mode'])) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
            
            // Update the setting
            SettingsHelper::set($field, $value);
            
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil diperbarui.',
                'field' => $field,
                'value' => $value
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        // Clear various caches
        Cache::flush();
        
        // Clear view cache
        \Artisan::call('view:clear');
        
        // Clear config cache
        \Artisan::call('config:clear');
        
        // Clear route cache
        \Artisan::call('route:clear');
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Cache berhasil dibersihkan.');
    }
    
    /**
     * Backup database.
     */
    public function backup()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupDir = storage_path('app/backups');
            $path = $backupDir . '/' . $filename;
            
            // Create backup directory if it doesn't exist
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            // Get database configuration
            $host = config('database.connections.mysql.host');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $database = config('database.connections.mysql.database');
            
            // Check if mysqldump is available
            $mysqldumpPath = 'mysqldump';
            if (PHP_OS_FAMILY === 'Windows') {
                // Try common paths for Windows
                $possiblePaths = [
                    'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                    'C:\\laragon\\bin\\mysql\\mysql-8.0.30\\bin\\mysqldump.exe',
                    'mysqldump'
                ];
                
                foreach ($possiblePaths as $testPath) {
                    if (file_exists($testPath) || shell_exec("where $testPath 2>nul")) {
                        $mysqldumpPath = $testPath;
                        break;
                    }
                }
            }
            
            // Build mysqldump command
            $command = sprintf(
                '"%s" --user=%s --password=%s --host=%s --routines --triggers %s > "%s"',
                $mysqldumpPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                $path
            );
            
            // Execute backup command
            $output = [];
            $returnCode = 0;
            exec($command . ' 2>&1', $output, $returnCode);
            
            // Check if backup was successful
            if ($returnCode !== 0 || !file_exists($path) || filesize($path) === 0) {
                // Fallback to Laravel-based backup if mysqldump fails
                $this->createLaravelBackup($path);
                
                if (!file_exists($path) || filesize($path) === 0) {
                    $errorMsg = 'Backup gagal. ';
                    if (!empty($output)) {
                        $errorMsg .= 'Error: ' . implode(' ', $output);
                    } else {
                        $errorMsg .= 'Mysqldump tidak tersedia dan fallback backup gagal.';
                    }
                    throw new \Exception($errorMsg);
                }
            }
            
            // Return file download
            return response()->download($path, $filename)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }
    
    /**
     * Create backup using Laravel database functionality as fallback.
     */
    private function createLaravelBackup($path)
    {
        try {
            $database = config('database.connections.mysql.database');
            $tables = DB::select('SHOW TABLES');
            $sql = "-- Laravel Database Backup\n";
            $sql .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                
                // Get table structure
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $sql .= "-- Table structure for `$tableName`\n";
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `$tableName`\n";
                    $sql .= "INSERT INTO `$tableName` VALUES\n";
                    
                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = [];
                        foreach ((array) $row as $value) {
                            if (is_null($value)) {
                                $rowData[] = 'NULL';
                            } else {
                                $rowData[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $values[] = '(' . implode(',', $rowData) . ')';
                    }
                    
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
            
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            
            file_put_contents($path, $sql);
            
        } catch (\Exception $e) {
            // If Laravel backup also fails, we'll let the main method handle the error
            throw $e;
        }
    }
    
    /**
     * Show system information.
     */
    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_version' => \DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown',
            'storage_used' => $this->formatBytes(disk_total_space(storage_path()) - disk_free_space(storage_path())),
            'storage_free' => $this->formatBytes(disk_free_space(storage_path())),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
        ];
        
        return view('admin.settings.system-info', compact('info'));
    }
    
    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
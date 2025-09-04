// Surat Form Dynamic Fields Handler
document.addEventListener('DOMContentLoaded', function() {
    const jenisSelect = document.getElementById('service_type');
    const dynamicFields = document.getElementById('dynamic-fields');
    
    // Field templates for different letter types
    const fieldTemplates = {
        'Domisili': [
            {
                name: 'lama_tinggal',
                label: 'Lama Tinggal',
                type: 'text',
                placeholder: 'Contoh: 5 tahun',
                required: true
            },
            {
                name: 'keperluan_domisili',
                label: 'Keperluan Surat Domisili',
                type: 'textarea',
                placeholder: 'Jelaskan keperluan surat domisili',
                required: true
            }
        ],
        'SKTM': [
            {
                name: 'pekerjaan_pemohon',
                label: 'Pekerjaan Pemohon',
                type: 'text',
                placeholder: 'Contoh: Buruh harian',
                required: true
            },
            {
                name: 'penghasilan_bulanan',
                label: 'Penghasilan Bulanan',
                type: 'text',
                placeholder: 'Contoh: Rp 500.000',
                required: true
            },
            {
                name: 'jumlah_tanggungan',
                label: 'Jumlah Tanggungan Keluarga',
                type: 'number',
                placeholder: 'Contoh: 3',
                required: true
            },
            {
                name: 'keperluan_sktm',
                label: 'Keperluan SKTM',
                type: 'textarea',
                placeholder: 'Jelaskan keperluan surat keterangan tidak mampu',
                required: true
            }
        ],
        'Usaha': [
            {
                name: 'nama_usaha',
                label: 'Nama Usaha',
                type: 'text',
                placeholder: 'Contoh: Warung Makan Sederhana',
                required: true
            },
            {
                name: 'jenis_usaha',
                label: 'Jenis Usaha',
                type: 'text',
                placeholder: 'Contoh: Kuliner',
                required: true
            },
            {
                name: 'alamat_usaha',
                label: 'Alamat Usaha',
                type: 'textarea',
                placeholder: 'Alamat lengkap lokasi usaha',
                required: true
            },
            {
                name: 'lama_usaha',
                label: 'Lama Usaha Berjalan',
                type: 'text',
                placeholder: 'Contoh: 2 tahun',
                required: true
            },
            {
                name: 'keperluan_sku',
                label: 'Keperluan Surat Keterangan Usaha',
                type: 'textarea',
                placeholder: 'Jelaskan keperluan surat keterangan usaha',
                required: true
            }
        ],
        'Pengantar': [
            {
                name: 'nama_calon_pasangan',
                label: 'Nama Calon Pasangan',
                type: 'text',
                placeholder: 'Nama lengkap calon pasangan',
                required: true
            },
            {
                name: 'tempat_lahir_pasangan',
                label: 'Tempat Lahir Calon Pasangan',
                type: 'text',
                placeholder: 'Tempat lahir calon pasangan',
                required: true
            },
            {
                name: 'tanggal_lahir_pasangan',
                label: 'Tanggal Lahir Calon Pasangan',
                type: 'date',
                required: true
            },
            {
                name: 'alamat_pasangan',
                label: 'Alamat Calon Pasangan',
                type: 'textarea',
                placeholder: 'Alamat lengkap calon pasangan',
                required: true
            },
            {
                name: 'rencana_tanggal_nikah',
                label: 'Rencana Tanggal Pernikahan',
                type: 'date',
                required: true
            },
            {
                name: 'tempat_nikah',
                label: 'Tempat Pernikahan',
                type: 'text',
                placeholder: 'Lokasi rencana pernikahan',
                required: true
            }
        ],
        'Kelahiran': [
            {
                name: 'nama_bayi',
                label: 'Nama Bayi',
                type: 'text',
                placeholder: 'Nama lengkap bayi',
                required: true
            },
            {
                name: 'jenis_kelamin_bayi',
                label: 'Jenis Kelamin Bayi',
                type: 'select',
                options: ['Laki-laki', 'Perempuan'],
                required: true
            },
            {
                name: 'tempat_lahir_bayi',
                label: 'Tempat Lahir Bayi',
                type: 'text',
                placeholder: 'Tempat lahir bayi',
                required: true
            },
            {
                name: 'tanggal_lahir_bayi',
                label: 'Tanggal Lahir Bayi',
                type: 'date',
                required: true
            },
            {
                name: 'nama_ayah',
                label: 'Nama Ayah',
                type: 'text',
                placeholder: 'Nama lengkap ayah',
                required: true
            },
            {
                name: 'nama_ibu',
                label: 'Nama Ibu',
                type: 'text',
                placeholder: 'Nama lengkap ibu',
                required: true
            },
            {
                name: 'penolong_kelahiran',
                label: 'Penolong Kelahiran',
                type: 'text',
                placeholder: 'Contoh: Bidan, Dokter, Dukun',
                required: true
            }
        ],
        'Kematian': [
            {
                name: 'nama_almarhum',
                label: 'Nama Almarhum/Almarhumah',
                type: 'text',
                placeholder: 'Nama lengkap yang meninggal',
                required: true
            },
            {
                name: 'nik_almarhum',
                label: 'NIK Almarhum/Almarhumah',
                type: 'text',
                placeholder: '16 digit NIK',
                required: true
            },
            {
                name: 'tempat_lahir_almarhum',
                label: 'Tempat Lahir Almarhum/Almarhumah',
                type: 'text',
                placeholder: 'Tempat lahir',
                required: true
            },
            {
                name: 'tanggal_lahir_almarhum',
                label: 'Tanggal Lahir Almarhum/Almarhumah',
                type: 'date',
                required: true
            },
            {
                name: 'tanggal_meninggal',
                label: 'Tanggal Meninggal',
                type: 'date',
                required: true
            },
            {
                name: 'tempat_meninggal',
                label: 'Tempat Meninggal',
                type: 'text',
                placeholder: 'Lokasi meninggal',
                required: true
            },
            {
                name: 'sebab_kematian',
                label: 'Sebab Kematian',
                type: 'text',
                placeholder: 'Penyebab kematian',
                required: true
            },
            {
                name: 'hubungan_pelapor',
                label: 'Hubungan dengan Pelapor',
                type: 'text',
                placeholder: 'Contoh: Anak, Suami, Istri',
                required: true
            }
        ],
        'Pindah': [
            {
                name: 'alamat_asal',
                label: 'Alamat Asal',
                type: 'textarea',
                placeholder: 'Alamat lengkap asal',
                required: true
            },
            {
                name: 'alamat_tujuan',
                label: 'Alamat Tujuan',
                type: 'textarea',
                placeholder: 'Alamat lengkap tujuan',
                required: true
            },
            {
                name: 'alasan_pindah',
                label: 'Alasan Pindah',
                type: 'textarea',
                placeholder: 'Jelaskan alasan pindah',
                required: true
            },
            {
                name: 'tanggal_pindah',
                label: 'Tanggal Pindah',
                type: 'date',
                required: true
            }
        ]
    };
    
    // Function to create form field
    function createField(field) {
        const fieldDiv = document.createElement('div');
        fieldDiv.className = 'mb-4';
        
        const label = document.createElement('label');
        label.className = 'block text-sm font-medium text-gray-700 mb-2';
        label.textContent = field.label;
        if (field.required) {
            label.innerHTML += ' <span class="text-red-500">*</span>';
        }
        
        let input;
        
        if (field.type === 'textarea') {
            input = document.createElement('textarea');
            input.rows = 3;
        } else if (field.type === 'select') {
            input = document.createElement('select');
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih ' + field.label;
            input.appendChild(defaultOption);
            
            // Add options
            field.options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.textContent = option;
                input.appendChild(optionElement);
            });
        } else {
            input = document.createElement('input');
            input.type = field.type;
        }
        
        input.name = `data_tambahan[${field.name}]`;
        input.id = field.name;
        input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500';
        
        if (field.placeholder) {
            input.placeholder = field.placeholder;
        }
        
        if (field.required) {
            input.required = true;
        }
        
        fieldDiv.appendChild(label);
        fieldDiv.appendChild(input);
        
        return fieldDiv;
    }
    
    // Function to update dynamic fields
    function updateDynamicFields() {
        const selectedType = jenisSelect.value;
        
        // Clear existing fields
        dynamicFields.innerHTML = '';
        
        if (selectedType && fieldTemplates[selectedType]) {
            const fields = fieldTemplates[selectedType];
            
            fields.forEach(field => {
                const fieldElement = createField(field);
                dynamicFields.appendChild(fieldElement);
            });
        }
    }
    
    // Event listener for jenis surat change
    if (jenisSelect) {
        jenisSelect.addEventListener('change', updateDynamicFields);
        
        // Initialize on page load if there's a selected value
        if (jenisSelect.value) {
            updateDynamicFields();
        }
    }
    
    // Form validation
    const form = document.getElementById('surat-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    // Remove error class on input
                    field.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.classList.remove('border-red-500');
                        }
                    });
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Show error message
                let errorDiv = document.getElementById('form-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.id = 'form-error';
                    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
                    form.insertBefore(errorDiv, form.firstChild);
                }
                errorDiv.textContent = 'Mohon lengkapi semua field yang wajib diisi.';
                
                // Scroll to top of form
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }
    
    // Auto-fill user data if available
    const userDataScript = document.getElementById('user-data');
    if (userDataScript) {
        try {
            const userData = JSON.parse(userDataScript.textContent);
            
            // Fill user data fields
            const namaField = document.getElementById('nama_pemohon');
            const nikField = document.getElementById('nik_pemohon');
            const alamatField = document.getElementById('alamat_pemohon');
            const phoneField = document.getElementById('phone_pemohon');
            
            if (namaField && userData.name) namaField.value = userData.name;
            if (nikField && userData.nik) nikField.value = userData.nik;
            if (alamatField && userData.alamat) alamatField.value = userData.alamat;
            if (phoneField && userData.phone) phoneField.value = userData.phone;
            
        } catch (e) {
            console.error('Error parsing user data:', e);
        }
    }
});
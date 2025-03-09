<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('customer.index') }}" class="text-primary hover:underline">Pelanggan</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" x-ref="form">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-5">
                    <div :class="[isSubmitForm ? (form.name ? 'has-success' : 'has-error') : '']">
                        <label for="customName">Nama</label>
                        <input id="customName" type="text" placeholder="Nama" class="form-input" x-model="form.name"
                            name="name" />
                        <template x-if="isSubmitForm && form.name">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.name">
                            <p class="text-danger mt-1">Harap isi Nama</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.email ? 'has-success' : 'has-error') : '']">
                        <label for="customEmail">Email</label>
                        <input id="customEmail" type="email" placeholder="Email" class="form-input"
                            x-model="form.email" name="email" />
                        <template x-if="isSubmitForm && form.email">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.email">
                            <p class="text-danger mt-1">Harap isi Email</p>
                        </template>
                    </div>
                </div>
                <div class="pt-5">
                    <div :class="[isSubmitForm ? (form.address ? 'has-success' : 'has-error') : '']">
                        <label for="customAddress">Alamat</label>
                        <textarea id="customAddress" rows="3" class="form-textarea" placeholder="Masukkan Alamat" x-model="form.address"
                            name="address"></textarea>
                        <template x-if="isSubmitForm && form.address">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.address">
                            <p class="text-danger mt-1">Harap isi Alamat</p>
                        </template>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-6">Simpan</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('form', () => ({
                form: {
                    name: '',
                    email: '',
                    address: '',
                },

                isSubmitForm: false,
                async submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.name && this.form.email && this.form.address) {
                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            const url = "{{ route('customer.store') }}";
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    name: this.form.name,
                                    email: this.form.email,
                                    address: this.form.address,
                                }),
                            });

                            if (response.ok) {
                                this.showMessage('Data berhasil disimpan', 'success');
                                setTimeout(() => {
                                    window.location.href = "{{ route('customer.index') }}";
                                }, 1500);
                            } else {
                                this.showMessage('Data gagal disimpan', 'error');
                            }
                        } catch (error) {
                            this.showMessage('Terjadi kesalahan: ' + error.message, 'error');
                        }
                    } else {
                        this.showMessage('Harap isi semua form', 'error');
                    }
                },

                showMessage(msg = '', type = 'success') {
                    const toast = window.Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    toast.fire({
                        icon: type,
                        title: msg,
                        padding: '10px 20px',
                    });
                },
            }));
        });
    </script>
</x-layout.default>

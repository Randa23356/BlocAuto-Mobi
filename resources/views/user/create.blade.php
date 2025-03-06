<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('user.index') }}" class="text-primary hover:underline">Pengguna</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" method="POST" action="{{ route('user.store') }}" x-ref="form">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div :class="[isSubmitForm ? (form.name ? 'has-success' : 'has-error') : '']">
                        <label for="customName">Nama</label>
                        <input id="customName" type="text" placeholder="Nama" class="form-input" x-model="form.name"
                            name="name" />
                        <template x-if="isSubmitForm && form.name">
                            <p class="text-success mt-1">Nama Sudah Sesuai</p>
                        </template>
                        <template x-if="isSubmitForm && !form.name">
                            <p class="text-danger mt-1">Harap isi Form Ini</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.role ? 'has-success' : 'has-error') : '']">
                        <label for="customRole">Pekerjaan</label>
                        <select id="customRole" class="form-select text-white-dark" x-model="form.role" name="role">
                            <option value="">Pilih Pekerjaan</option>
                            <option value="mechanic">Mekanik</option>
                            <option value="chasier">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                        <template x-if="isSubmitForm && form.role">
                            <p class="text-success mt-1">Sudah Terisi</p>
                        </template>
                        <template x-if="isSubmitForm && !form.role">
                            <p class="text-danger mt-1">Harap Pilih Perkerjaan</p>
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
                    role: '',
                },

                isSubmitForm: false,
                submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.name && this.form.role) {
                        this.$refs.form.submit();
                    } else {
                        this.showMessage('Harap isi Semua Form', 'error');
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

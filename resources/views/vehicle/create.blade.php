<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="/vehicle" class="text-primary hover:underline">Kendaraan</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" x-ref="form">
                @csrf
                <div class="gap-5">
                    <div :class="[isSubmitForm ? (form.customer ? 'has-success' : 'has-error') : '']">
                        <label for="customCustomer">Pelanggan</label>
                        <select id="customCustomer" class="form-select text-white-dark" x-model="form.customer"
                            name="customer_id">
                            <option value="">Pilih Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.customer">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.customer">
                            <p class="text-danger mt-1">Harap Pilih Pelanggan</p>
                        </template>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-5">
                        <div :class="[isSubmitForm ? (form.plat ? 'has-success' : 'has-error') : '']">
                            <label for="customPlat">Nomor Plat</label>
                            <input id="customPlat" type="text" placeholder="Nomor Plat" class="form-input"
                                x-model="form.plat" name="plat" />
                            <template x-if="isSubmitForm && form.plat">
                                <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                            </template>
                            <template x-if="isSubmitForm && !form.plat">
                                <p class="text-danger mt-1">Harap isi Nomor Plat</p>
                            </template>
                        </div>
                        <div :class="[isSubmitForm ? (form.brand ? 'has-success' : 'has-error') : '']">
                            <label for="customBrand">Merek</label>
                            <input id="customBrand" type="text" placeholder="Merek" class="form-input"
                                x-model="form.brand" name="brand" />
                            <template x-if="isSubmitForm && form.brand">
                                <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                            </template>
                            <template x-if="isSubmitForm && !form.brand">
                                <p class="text-danger mt-1">Harap isi Merek</p>
                            </template>
                        </div>
                    </div>
                    <div class="pt-5" :class="[isSubmitForm ? (form.year ? 'has-success' : 'has-error') : '']">
                        <label for="customYear">Tahun</label>
                        <input id="customYear" type="number" placeholder="Tahun" class="form-input" x-model="form.year"
                            name="year" />
                        <template x-if="isSubmitForm && form.year">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.year">
                            <p class="text-danger mt-1">Harap isi Tahun</p>
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
                    customer: '',
                    plat: '',
                    brand: '',
                    year: '',
                },

                isSubmitForm: false,
                async submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.customer && this.form.plat && this.form.brand && this.form.year) {
                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            const url = "{{ route('vehicle.store') }}";
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    customer_id: this.form.customer,
                                    plat: this.form.plat,
                                    brand: this.form.brand,
                                    year: this.form.year,
                                }),
                            });

                            if (response.ok) {
                                this.showMessage('Data berhasil disimpan', 'success');
                                setTimeout(() => {
                                    window.location.href = "{{ route('vehicle.index') }}";
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

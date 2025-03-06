<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="/vehicle" class="text-primary hover:underline">Kendaraan</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" method="POST" action="{{ route('vehicle.update', $vehicle->id) }}"
                x-ref="form">
                @csrf
                @method('PUT')
                <div class="gap-5">
                    <div :class="[isSubmitForm ? (form.customer_id ? 'has-success' : 'has-error') : '']">
                        <label for="customCustomer">Pelanggan</label>
                        <select id="customCustomer" class="form-select text-white-dark" x-model="form.customer_id"
                            name="customer_id">
                            <option value="">Pilih Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $vehicle->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.customer_id">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.customer_id">
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
                    customer_id: '{{ $vehicle->customer_id }}',
                    plat: '{{ $vehicle->plat }}',
                    brand: '{{ $vehicle->brand }}',
                    year: '{{ $vehicle->year }}',
                },

                isSubmitForm: false,
                submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.customer_id && this.form.plat && this.form.brand && this.form.year) {
                        this.$refs.form.submit();
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

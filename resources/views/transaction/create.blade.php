<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="/transactions" class="text-primary hover:underline">Transaksi</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" method="POST" action="{{ route('transaction.store') }}" x-ref="form">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div :class="[isSubmitForm ? (form.mechanic ? 'has-success' : 'has-error') : '']">
                        <label for="customMechanic">Mekanik</label>
                        <select id="customMechanic" class="form-select text-white-dark" x-model="form.mechanic"
                            name="mechanic_id">
                            <option value="">Pilih Mekanik</option>
                            @foreach ($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.mechanic">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.mechanic">
                            <p class="text-danger mt-1">Harap Pilih Mekanik</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.customer ? 'has-success' : 'has-error') : '']">
                        <label for="customCustomer">Customer</label>
                        <select id="customCustomer" class="form-select text-white-dark" x-model="form.customer"
                            name="customer_id">
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.customer">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.customer">
                            <p class="text-danger mt-1">Harap Pilih Customer</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.vehicle ? 'has-success' : 'has-error') : '']">
                        <label for="customVehicle">Kendaraan</label>
                        <select id="customVehicle" class="form-select text-white-dark" x-model="form.vehicle"
                            name="vehicle_id">
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->brand }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.vehicle">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.vehicle">
                            <p class="text-danger mt-1">Harap Pilih Kendaraan</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.chasier ? 'has-success' : 'has-error') : '']">
                        <label for="customChasier">Kasir</label>
                        <select id="customChasier" class="form-select text-white-dark" x-model="form.chasier"
                            name="chasier_id">
                            <option value="">Pilih Kasir</option>
                            @foreach ($chasiers as $chasier)
                                <option value="{{ $chasier->id }}">{{ $chasier->name }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.chasier">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.chasier">
                            <p class="text-danger mt-1">Harap Pilih Kasir</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.spare_parts ? 'has-success' : 'has-error') : '']">
                        <label for="customSparePart">Suku Cadang</label>
                        <select id="customSparePart" class="form-select text-white-dark" x-model="form.spare_parts"
                            name="spare_parts" @change="calculateGrandTotal">
                            <option value="">Pilih Suku Cadang</option>
                            @foreach ($spareParts as $sparePart)
                                <option value="{{ $sparePart->id }}" data-price="{{ $sparePart->price }}">
                                    {{ $sparePart->name }}</option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.spare_parts">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.spare_parts">
                            <p class="text-danger mt-1">Harap Pilih Suku Cadang</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.quantity ? 'has-success' : 'has-error') : '']">
                        <label for="customQuantity">Jumlah</label>
                        <input id="customQuantity" type="number" placeholder="Jumlah" class="form-input"
                            x-model="form.quantity" name="quantity" @input="calculateGrandTotal" />
                        <template x-if="isSubmitForm && form.quantity">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.quantity">
                            <p class="text-danger mt-1">Harap isi Jumlah</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.date ? 'has-success' : 'has-error') : '']">
                        <label for="customDate">Tanggal</label>
                        <input id="customDate" type="date" class="form-input" x-model="form.date" name="date" />
                        <template x-if="isSubmitForm && form.date">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.date">
                            <p class="text-danger mt-1">Harap isi Tanggal</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.grand_total ? 'has-success' : 'has-error') : '']">
                        <label for="customGrandTotal">Grand Total</label>
                        <input id="customGrandTotal" type="number" placeholder="Grand Total" class="form-input"
                            x-model="form.grand_total" name="grand_total" readonly />
                        <template x-if="isSubmitForm && form.grand_total">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.grand_total">
                            <p class="text-danger mt-1">Harap isi Grand Total</p>
                        </template>
                    </div>
                </div>
                <div class="pt-5">
                    <div :class="[isSubmitForm ? (form.description ? 'has-success' : 'has-error') : '']">
                        <label for="customDescription">Deskripsi</label>
                        <textarea id="customDescription" rows="4" class="form-textarea ltr:rounded-l-none rtl:rounded-r-none"
                            x-model="form.description" name="description"></textarea>
                        <template x-if="isSubmitForm && form.description">
                            <p class="text-success mt-1"> Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.description">
                            <p class="text-danger mt-1">Harap isi Deskripsi</p>
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
                    mechanic: '',
                    customer: '',
                    vehicle: '',
                    chasier: '',
                    spare_parts: '',
                    quantity: '',
                    date: '',
                    grand_total: '',
                    description: '',
                },

                isSubmitForm: false,
                submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.mechanic && this.form.vehicle && this.form.customer && this.form
                        .chasier && this.form
                        .spare_parts && this.form.quantity && this.form.date && this.form.grand_total &&
                        this.form.description) {
                        this.$refs.form.submit();
                    } else {
                        this.showMessage('Harap isi semua form', 'error');
                    }
                },

                calculateGrandTotal() {
                    const sparePartElement = document.getElementById('customSparePart');
                    const selectedOption = sparePartElement.options[sparePartElement.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const quantity = this.form.quantity;

                    if (price && quantity) {
                        this.form.grand_total = price * quantity;
                    } else {
                        this.form.grand_total = '';
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

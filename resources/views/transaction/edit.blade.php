<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('transaction.index') }}" class="text-primary hover:underline">Transaksi</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>

    <div class="pt-5" x-data="form">
        <div class="panel">
            <form @submit.prevent="submitForm()" x-ref="form">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div :class="[isSubmitForm ? (form.mechanic ? 'has-success' : 'has-error') : '']">
                        <label for="customMechanic">Mekanik</label>
                        <select id="customMechanic" class="form-select text-white-dark" name="mechanic_id"
                            x-model="form.mechanic">
                            <option value="">Pilih Mekanik</option>
                            @foreach ($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}"
                                    {{ $transaction->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                                    {{ $mechanic->name }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.mechanic">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.mechanic">
                            <p class="text-danger mt-1">Harap Pilih Mekanik</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.vehicle ? 'has-success' : 'has-error') : '']">
                        <label for="customVehicle">Kendaraan</label>
                        <select id="customVehicle" class="form-select text-white-dark" name="vehicle_id"
                            x-model="form.vehicle">
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ $transaction->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->brand }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.vehicle">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.vehicle">
                            <p class="text-danger mt-1">Harap Pilih Kendaraan</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.chasier ? 'has-success' : 'has-error') : '']">
                        <label for="customChasier">Kasir</label>
                        <select id="customChasier" class="form-select text-white-dark" name="chasier_id"
                            x-model="form.chasier">
                            <option value="">Pilih Kasir</option>
                            @foreach ($chasiers as $chasier)
                                <option value="{{ $chasier->id }}"
                                    {{ $transaction->chasier_id == $chasier->id ? 'selected' : '' }}>
                                    {{ $chasier->name }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.chasier">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.chasier">
                            <p class="text-danger mt-1">Harap Pilih Kasir</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.customer ? 'has-success' : 'has-error') : '']">
                        <label for="customCustomer">Customer</label>
                        <select id="customCustomer" class="form-select text-white-dark" name="customer_id"
                            x-model="form.customer">
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $transaction->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.customer">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.customer">
                            <p class="text-danger mt-1">Harap Pilih Customer</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.spare_parts ? 'has-success' : 'has-error') : '']">
                        <label for="customSparePart">Suku Cadang</label>
                        <select id="customSparePart" class="form-select text-white-dark" name="spare_parts"
                            x-model="form.spare_parts" @change="calculateGrandTotal">
                            <option value="">Pilih Suku Cadang</option>
                            @foreach ($spareParts as $sparePart)
                                <option value="{{ $sparePart->id }}" data-price="{{ $sparePart->price }}"
                                    {{ $transaction->spare_parts == $sparePart->id ? 'selected' : '' }}>
                                    {{ $sparePart->name }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="isSubmitForm && form.spare_parts">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.spare_parts">
                            <p class="text-danger mt-1">Harap Pilih Suku Cadang</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.quantity ? 'has-success' : 'has-error') : '']">
                        <label for="customQuantity">Jumlah</label>
                        <input id="customQuantity" type="number" placeholder="Jumlah" class="form-input"
                            name="quantity" x-model="form.quantity" @input="calculateGrandTotal" required />
                        <template x-if="isSubmitForm && form.quantity">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.quantity">
                            <p class="text-danger mt-1">Harap Isi Jumlah</p>
                        </template>
                    </div>
                    <div :class="[isSubmitForm ? (form.date ? 'has-success' : 'has-error') : '']">
                        <label for="customDate">Tanggal</label>
                        <input id="customDate" type="date" class="form-input" name="date" x-model="form.date"
                            required />
                        <template x-if="isSubmitForm && form.date">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.date">
                            <p class="text-danger mt-1">Harap Isi Tanggal</p>
                        </template>
                    </div>
                </div>
                <div class="pt-5">
                    <div :class="[isSubmitForm ? (form.grand_total ? 'has-success' : 'has-error') : '']">
                        <label for="customGrandTotal">Grand Total</label>
                        <input id="customGrandTotal" type="number" placeholder="Grand Total" class="form-input"
                            name="grand_total" x-model="form.grand_total" readonly required />
                        <template x-if="isSubmitForm && form.grand_total">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.grand_total">
                            <p class="text-danger mt-1">Harap Isi Grand Total</p>
                        </template>
                    </div>
                    <div class="pt-5"
                        :class="[isSubmitForm ? (form.description ? 'has-success' : 'has-error') : '']">
                        <label for="customDescription">Deskripsi</label>
                        <textarea id="customDescription" rows="4" class="form-textarea ltr:rounded-l-none rtl:rounded-r-none"
                            name="description" x-model="form.description"></textarea>
                        <template x-if="isSubmitForm && form.description">
                            <p class="text-success mt-1">Mantap Sudah Terisi!</p>
                        </template>
                        <template x-if="isSubmitForm && !form.description">
                            <p class="text-danger mt-1">Harap Isi Deskripsi</p>
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
                    mechanic: '{{ $transaction->mechanic_id }}',
                    customer: '{{ $transaction->customer_id }}',
                    vehicle: '{{ $transaction->vehicle_id }}',
                    chasier: '{{ $transaction->chasier_id }}',
                    spare_parts: '{{ $transaction->spare_parts }}',
                    quantity: '{{ $transaction->quantity }}',
                    date: '{{ $transaction->date }}',
                    grand_total: '{{ $transaction->grand_total }}',
                    description: '{{ $transaction->description }}',
                },

                isSubmitForm: false,
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

                async submitForm() {
                    this.isSubmitForm = true;
                    if (this.form.mechanic && this.form.customer && this.form.vehicle && this.form
                        .chasier && this.form.spare_parts && this.form.quantity && this.form.date &&
                        this.form.grand_total && this.form.description) {
                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            const url = "{{ route('transaction.update', $transaction->id) }}";
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    _method: 'PUT',
                                    mechanic_id: this.form.mechanic,
                                    customer_id: this.form.customer,
                                    vehicle_id: this.form.vehicle,
                                    chasier_id: this.form.chasier,
                                    spare_parts: this.form.spare_parts,
                                    quantity: this.form.quantity,
                                    date: this.form.date,
                                    grand_total: this.form.grand_total,
                                    description: this.form.description,
                                }),
                            });

                            if (response.ok) {
                                this.showMessage('Data berhasil diperbaharui', 'success');
                                new window.Swal({
                                    title: 'Berhasil!',
                                    text: 'Data transaksi berhasil diperbarui.',
                                    icon: 'success',
                                    customClass: 'sweet-alerts'
                                }).then(() => {
                                    window.location.href =
                                        "{{ route('transaction.index') }}";
                                });
                            } else {
                                this.showMessage('Data gagal diperbaharui', 'error');
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

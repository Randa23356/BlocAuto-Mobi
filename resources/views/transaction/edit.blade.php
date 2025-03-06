<x-layout.default>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('transaction.index') }}" class="text-primary hover:underline">Transaksi</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>

    <div class="pt-5">
        <div class="panel">
            <form method="POST" action="{{ route('transaction.update', $transaction->id) }}" x-data="form">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
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
                    </div>
                    <div>
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
                    </div>
                    <div>
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
                    </div>
                    <div>
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
                    </div>
                    <div>
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
                    </div>
                    <div>
                        <label for="customQuantity">Jumlah</label>
                        <input id="customQuantity" type="number" placeholder="Jumlah" class="form-input"
                            name="quantity" x-model="form.quantity" @input="calculateGrandTotal" required />
                    </div>
                    <div>
                        <label for="customDate">Tanggal</label>
                        <input id="customDate" type="date" class="form-input" name="date" x-model="form.date"
                            required />
                    </div>
                </div>
                <div class="pt-5">
                    <div>
                        <label for="customGrandTotal">Grand Total</label>
                        <input id="customGrandTotal" type="number" placeholder="Grand Total" class="form-input"
                            name="grand_total" x-model="form.grand_total" readonly required />
                    </div>
                    <div class="pt-5">
                        <label for="customDescription">Deskripsi</label>
                        <textarea id="customDescription" rows="4" class="form-textarea ltr:rounded-l-none rtl:rounded-r-none"
                            name="description" x-model="form.description"></textarea>
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
            }));
        });
    </script>
</x-layout.default>

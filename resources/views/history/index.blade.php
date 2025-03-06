<x-layout.default>
    <div x-data="striped" class="panel mt-6">
        <h5 class="md:absolute md:top-[25px] md:mb-0 mb-5 font-semibold text-lg dark:text-white-light">Riwayat Transaksi
        </h5>
        <table id="tableAll" class="table-striped table-hover table-bordered table-compact"></table>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("striped", () => ({
                transactions: @json($transactions->toArray()),
                dataTable: null,
                init() {
                    this.initDataTable();
                },
                initDataTable() {
                    const transactionDestroyUrl =
                        "{{ route('transaction.destroy', ['transaction' => ':id']) }}";
                    const tableOptions = {
                        data: {
                            headings: ["ID", "Mekanik", "Kendaraan", "Nomor Plat", "Customer",
                                "Kasir", "Suku Cadang", "Jumlah", "Tanggal", "Grand Total",
                                "Deskripsi", "Aksi"
                            ],
                            data: this.transactions.map((transaction, index) => {
                                const destroyTransaction = transactionDestroyUrl.replace(
                                    ':id', transaction.id);
                                return [
                                    index + 1,
                                    transaction.mechanic ? transaction.mechanic.name :
                                    'Tidak ada mekanik',
                                    transaction.vehicle ? transaction.vehicle.brand :
                                    'Tidak ada kendaraan',
                                    transaction.vehicle ? transaction.vehicle.plat :
                                    'Tidak ada plat',
                                    transaction.customer ? transaction.customer.name :
                                    'Tidak ada customer',
                                    transaction.chasier ? transaction.chasier.name :
                                    'Tidak ada kasir',
                                    transaction.spare_part ? transaction.spare_part
                                    .name : 'Tidak ada suku cadang',
                                    transaction.quantity,
                                    transaction.date,
                                    transaction.grand_total,
                                    transaction.description,
                                    `<div class="flex items-center gap-2">
                                        <button @click.prevent="confirmDelete(${transaction.id})" type="button">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5" d="M11.3456 22H12.1544C14.9371 22 16.3285 22 17.2331 21.0936C18.1378 20.1873 18.2303 18.7005 18.4154 15.727L18.6821 11.4425C18.7826 9.82908 18.8328 9.02238 18.3789 8.51119C17.9251 8 17.1587 8 15.626 8H7.87405C6.34127 8 5.57488 8 5.12105 8.51119C4.66722 9.02238 4.71744 9.82908 4.81788 11.4425L5.08459 15.727C5.2697 18.7005 5.36225 20.1873 6.26689 21.0936C7.17153 22 8.56289 22 11.3456 22Z" fill="#1C274C"/>
                                                <path d="M2.75 6.16667C2.75 5.70644 3.09538 5.33335 3.52143 5.33335L6.18567 5.3329C6.71502 5.31841 7.18202 4.95482 7.36214 4.41691C7.36688 4.40277 7.37232 4.38532 7.39185 4.32203L7.50665 3.94993C7.5769 3.72179 7.6381 3.52303 7.72375 3.34536C8.06209 2.64349 8.68808 2.1561 9.41147 2.03132C9.59457 1.99973 9.78848 1.99987 10.0111 2.00002H13.4891C13.7117 1.99987 13.9056 1.99973 14.0887 2.03132C14.8121 2.1561 15.4381 2.64349 15.7764 3.34536C15.8621 3.52303 15.9233 3.72179 15.9935 3.94993L16.1083 4.32203C16.1279 4.38532 16.1333 4.40277 16.138 4.41691C16.3182 4.95482 16.8778 5.31886 17.4071 5.33335H19.9786C20.4046 5.33335 20.75 5.70644 20.75 6.16667C20.75 6.62691 20.4046 7 19.9786 7H3.52143C3.09538 7 2.75 6.62691 2.75 6.16667Z" fill="#1C274C"/>
                                            </svg>
                                        </button>
                                    </div>`
                                ];
                            })
                        },
                        sortable: false,
                        searchable: true,
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "{select}"
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    };
                    this.dataTable = new simpleDatatables.DataTable('#tableAll', tableOptions);
                },
                async showConfirmDialog() {
                    return new Promise((resolve) => {
                        new window.Swal({
                            icon: 'warning',
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            showCancelButton: true,
                            confirmButtonText: 'Delete',
                            padding: '2em',
                        }).then((result) => {
                            resolve(result.isConfirmed);
                        });
                    });
                },
                async confirmDelete(transactionId) {
                    const isConfirmed = await this.showConfirmDialog();
                    if (isConfirmed) {
                        await this.deleteTransaction(transactionId);
                    }
                },
                async deleteTransaction(transactionId) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');
                    const rute = "{{ route('transaction.destroy', ':id') }}";
                    const url = rute.replace(':id', transactionId);
                    try {
                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                        });
                        const responseText = await response.text();
                        console.log('Response status:', response.status);
                        console.log('Response text:', responseText);

                        const contentType = response.headers.get('Content-Type');
                        if (contentType && contentType.includes('application/json')) {
                            const responseData = JSON.parse(responseText);
                            console.log('Response data:', responseData);
                            if (response.ok) {
                                this.removeTransactionFromList(transactionId);
                                this.showMessage("Data berhasil dihapus", "success");
                                new window.Swal({
                                    title: 'Deleted!',
                                    text: 'Your file has been deleted.',
                                    icon: 'success',
                                    customClass: 'sweet-alerts'
                                });
                            } else {
                                this.showMessage("Data gagal dihapus", "error");
                            }
                        } else {
                            console.error('Unexpected response format:', responseText);
                            this.showMessage("Data gagal dihapus: Unexpected response format",
                                "error");
                        }
                    } catch (e) {
                        console.error('Error:', e);
                        this.showMessage("Terjadi kesalahan: " + e.message, "error");
                    }
                },
                removeTransactionFromList(transactionId) {
                    const index = this.transactions.findIndex(data => data.id === transactionId);
                    if (index !== -1) {
                        this.transactions.splice(index, 1);
                        if (this.dataTable) {
                            this.dataTable.destroy();
                            this.initDataTable();
                        }
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

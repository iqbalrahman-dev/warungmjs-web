<?php
require_once 'backend/dashboard_data.php';

$selectedDate = $_GET['date'] ?? null;
$data = get_today_dashboard_data($selectedDate);
$ingredient_purchases = $data['ingredient_purchases'];
$product_sales = $data['product_sales'];

$monthly_data = get_monthly_totals();
$month = $monthly_data['month'];
$monthly_ingredient_total = $monthly_data['monthly_ingredient_total'];
$monthly_sales_total = $monthly_data['monthly_sales_total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung MJS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Inter', sans-serif;
      }
      .active {
        color: #3b82f6; /* Tailwind's blue-500 */
      }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow-md">
        <nav class="container mx-auto p-4 flex items-center justify-between">
            <ul class="flex space-x-4">
                <li>
                    <a href="index.php" class="text-blue-600 hover:text-blue-600 font-semibold active">Beranda</a>
                </li>
                <li>
                    <a href="ingredients.php" class="text-gray-700 hover:text-blue-600 font-semibold">Bahan Makanan</a>
                </li>
                <li>
                    <a href="foods.php" class="text-gray-700 hover:text-blue-600 font-semibold">Makanan</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div id="home-page" class="container mx-auto p-4">
            <div class="flex items-center space-x-4 mb-4">
                <img src="https://img001.prntscr.com/file/img001/5HZvE9uZTsyK6TRgu4xFIA.png" alt="Warung MJS Logo" class="h-13 w-20 object-cover rounded-xl">
                <h1 class="text-3xl font-bold text-gray-800">Warung Makan MJS</h1>
            </div>

            <p class="text-gray-600 mb-6">Daftar belanja dan pejualan harian: (<?php echo $selectedDate; ?>)</p>
            <form method="GET" class="mb-4">
                <label for="date" class="text-gray-700 font-semibold mr-2">Pilih Tanggal:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($today); ?>" class="border border-gray-300 p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2 hover:bg-blue-600">Tampilkan</button>
            </form>

            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Pembelian Bahan Makanan</h2>
            <?php if (count($ingredient_purchases) > 0): ?>
                <div class="bg-white p-4 rounded-lg shadow mb-6">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full min-w-[600px] table-auto text-left">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-2 min-w-[150px]">Nama</th>
                                    <th class="p-2">Jumlah</th>
                                    <th class="p-2 min-w-[150px]">Harga/Unit</th>
                                    <th class="p-2 min-w-[150px]">Diskon</th>
                                    <th class="p-2 min-w-[150px]">Total</th>
                                    <th class="p-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ingredient_purchases as $purchase): ?>
                                    <tr class="border-b">
                                        <td class="p-2 min-w-[150px]"><?php echo htmlspecialchars($purchase['name']); ?></td>
                                        <td class="p-2"><?php echo $purchase['quantity']; ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($purchase['price_per_unit'], 2, ',', '.'); ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($purchase['discount'], 2, ',', '.'); ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($purchase['total_cost'], 2, ',', '.'); ?></td>
                                        <td class="p-2">
                                            <form method="POST" action="backend/ingredients_delete.php" onsubmit="return confirmDelete();">
                                                <input type="hidden" name="id" value="<?php echo $purchase['id']; ?>">
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold bg-gray-100">
                                    <td colspan="4" class="p-2 text-right">Total Pengeluaran:</td>
                                    <td class="p-2">Rp. <?php echo number_format($data['total_ingredient_cost'], 2, ',', '.'); ?></td>
                                    <td class="p-2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-gray-600 mb-6">Tidak ada pembelian hari ini.</p>
            <?php endif; ?>

            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Penjualan Makanan</h2>
            <?php if (count($product_sales) > 0): ?>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full table-auto text-left">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-2 min-w-[150px]">Nama</th>
                                    <th class="p-2">Jumlah</th>
                                    <th class="p-2 min-w-[150px]">Harga/Unit</th>
                                    <th class="p-2 min-w-[150px]">Diskon</th>
                                    <th class="p-2 min-w-[150px]">Total</th>
                                    <th class="p-2 min-w-[150px]"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_sales as $sale): ?>
                                    <tr class="border-b">
                                        <td class="p-2 min-w-[150px]"><?php echo htmlspecialchars($sale['name']); ?></td>
                                        <td class="p-2"><?php echo $sale['quantity_sold']; ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($sale['price_per_unit'], 2, ',', '.'); ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($sale['discount'], 2, ',', '.'); ?></td>
                                        <td class="p-2 min-w-[150px]">Rp. <?php echo number_format($sale['total_price'], 2, ',', '.'); ?></td>
                                        <td class="p-2">
                                            <form method="POST" action="backend/foods_delete.php" onsubmit="return confirmDelete();">
                                                <input type="hidden" name="id" value="<?php echo $sale['id']; ?>">
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold bg-gray-100">
                                    <td colspan="4" class="p-2 text-right">Total Penjualan:</td>
                                    <td class="p-2">Rp. <?php echo number_format($data['total_product_sale'], 2, ',', '.'); ?></td>
                                    <td class="p-2"></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-gray-600">Tidak ada penjualan hari ini.</p>
            <?php endif; ?>

            <div class="bg-white p-4 rounded-lg shadow mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Ringkasan Bulan Ini (<?php echo $month; ?>)</h2>
                <p class="text-gray-700">Total Pembelian Bahan: <strong>Rp. <?php echo number_format($monthly_ingredient_total, 2, ',', '.'); ?></strong></p>
                <p class="text-gray-700">Total Penjualan Produk: <strong>Rp. <?php echo number_format($monthly_sales_total, 2, ',', '.'); ?></strong></p>
            </div>


        </div>
    </main>

    <footer class="bg-white mt-8 py-4 text-center text-gray-500">
        &copy; 2025 Warung MJS
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('header nav ul li a');
        const currentPage = window.location.pathname.split('/').pop();

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });

    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus item ini?');
    }
    </script>
</body>
</html>
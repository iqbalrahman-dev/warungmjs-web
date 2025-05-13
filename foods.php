<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];

    if ($message == "success") {
        $success_message = "Berhasil menambahkan data makanan";
    } elseif ($message == "error") {
        $error_message = "Gagal menambahkan data makanan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .active { color: #3b82f6; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow-md">
        <nav class="container mx-auto p-4">
            <ul class="flex space-x-4">
                <li><a href="index.php" class="text-gray-700 hover:text-blue-600 font-semibold">Beranda</a></li>
                <li><a href="ingredients.php" class="text-gray-700 hover:text-blue-600 font-semibold">Bahan Makanan</a></li>
                <li><a href="foods.php" class="text-blue-600 hover:text-blue-600 font-semibold active">Makanan</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Data Makanan</h1>

            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Success!</strong> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Error!</strong> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="backend/foods_data.php" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-gray-700 font-bold">Nama Makanan:</label>
                        <input type="text" name="name" id="name" required class="w-full p-2 border rounded" placeholder="Nama makanan">
                    </div>
                    <div>
                        <label for="quantity_sold" class="block text-gray-700 font-bold">Jumlah Terjual:</label>
                        <input type="number" name="quantity_sold" id="quantity_sold" required class="w-full p-2 border rounded" placeholder="Jumlah terjual">
                    </div>
                    <div>
                        <label for="price_per_unit" class="block text-gray-700 font-bold">Harga per Unit:</label>
                        <input type="number" name="price_per_unit" id="price_per_unit" required class="w-full p-2 border rounded" placeholder="Harga per unit">
                    </div>
                    <div>
                        <label for="discount" class="block text-gray-700 font-bold">Diskon:</label>
                        <input type="number" name="discount" id="discount" value="0" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="description" class="block text-gray-700 font-bold">Deskripsi:</label>
                        <textarea name="description" id="description" class="w-full p-2 border rounded" placeholder="Deskripsi makanan"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label for="product_date" class="block text-gray-700 text-sm font-bold mb-1">Tanggal Pembelian:</label>
                        <input type="date" name="product_date" id="product_date" required
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Tambah Makanan</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white text-center text-gray-500 py-4 mt-8">
        &copy; 2025 My Simple Website
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('header nav ul li a');
        const currentPage = window.location.pathname.split('/').pop();
        navLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === currentPage);
        });
    });
    </script>
</body>
</html>

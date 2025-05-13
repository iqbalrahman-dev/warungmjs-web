<?php
if (isset($_GET['message'])) {
    $message = $_GET['message'];

    if ($message == "success") {
        $success_message = "Berhasil menambahkan data bahan makanan";
    } elseif ($message == "error") {
        $error_message = "Gagal menambahkan bahan makanan.";
    }
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredients</title>
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
        <nav class="container mx-auto p-4">
            <ul class="flex space-x-4">
                <li>
                    <a href="index.php" class="text-gray-700 hover:text-blue-600 font-semibold">Beranda</a>
                </li>
                <li>
                    <a href="ingredients.php" class="text-blue-600 hover:text-blue-600 font-semibold active">Bahan Makanan</a>
                </li>
                <li>
                    <a href="foods.php" class="text-gray-700 hover:text-blue-600 font-semibold">Makanan</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div id="ingredients-page" class="container mx-auto p-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Bahan Makanan</h1>

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

            <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Pembelian Bahan Makanan</h2>
                <form method="post" action="backend/ingredients_data.php" class="space-y-4">
                    <div class="soace-y-2">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-1">Nama:</label>
                        <input type="text" name="name" id="name" placeholder="Nama" required class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="space-y-2">
                        <label for="quantity" class="block text-gray-700 text-sm font-bold mb-1">Kuantitas:</label>
                        <input type="number" name="quantity" id="quantity" placeholder="Kuantitas" required class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="space-y-2">
                        <label for="price_per_unit" class="block text-gray-700 text-sm font-bold mb-1">Harga per Unit:</label>
                        <input type="number" name="price_per_unit" id="price_per_unit" placeholder="Harga per kg/g/liter" required class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="space-y-2">
                        <label for="discount" class="block text-gray-700 text-sm font-bold mb-1">Diskon:</label>
                        <input type="number" name="discount" id="discount" value="0" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="space-y-2">
                        <label for="notes" class="block text-gray-700 text-sm font-bold mb-1">Catatan:</label>
                        <textarea name="notes" id="notes" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label for="purchase_date" class="block text-gray-700 text-sm font-bold mb-1">Tanggal Pembelian:</label>
                        <input type="date" name="purchase_date" id="purchase_date" required
                            class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <button type="submit" value="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Tambah Pembelian
                    </button>
                </form> 
            </div>
        </div>
    </main>

    <footer class="bg-white mt-8 py-4 text-center text-gray-500">
        &copy; 2025 My Simple Website
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
    </script>
</body>
</html>
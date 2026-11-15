<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SECTION B: LIST OF CHOICES</title>
    <link href="assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 p-4 md:p-8 font-sans">

    <div class="max-w-4xl mx-auto">
        <h2 class="text-blue-700 font-bold border-b-2 border-blue-700 pb-2 mb-4 text-2xl">SECTION B: LIST OF CHOICES</h2>

        <!-- NOTIFICATION MESSAGE -->
        <div id="toast" class="hidden bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mb-4 text-sm">
            <span class="block sm:inline"></span>
        </div>

        <!-- 1. INJECT FORM COMPONENT -->
        <?php include 'components/view-form.php'; ?>

        <!-- 2. INJECT LIST COMPONENT -->
        <?php include 'components/view-company-list.php'; ?>
        
    </div>

    <!-- MAIN SPA LOGIC -->
    <script src="assets/js/app.js"></script>
</body>
</html>

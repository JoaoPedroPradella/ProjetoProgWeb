<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Usuario;

Usuario::deslogar();

echo json_encode(['status' => 'sucesso']);

exit;
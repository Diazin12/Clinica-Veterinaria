<?php
$consultasIniciais = [
    ["id" => 1, "pet" => "Luna (Labrador)",  "tutor" => "Ana Souza",  "servico" => "Consulta",  "veterinario" => "Dra.Brinquedos",  "data" => "2026-10-20", "hora" => "08:00", "status" => "agendado"],
    ["id" => 2, "pet" => "Rex (Pastor Alemão)", "tutor" => "Carlos Lima",  "servico" => "Vacinação",  "veterinario" => "Dra.Brinquedos",   "data" => "2026-10-21", "hora" => "09:30", "status" => "confirmado"],
    ["id" => 3, "pet" => "Mel (SRD)",  "tutor" => "Mariana Costa",  "servico" => "Exame",  "veterinario" => "Dra.Brinquedos",  "data" => "2026-10-22", "hora" => "11:00", "status" => "agendado"],
    ["id" => 4, "pet" => "Thor (Golden)",  "tutor" => "Pedro Alves",  "servico" => "Consulta",    "veterinario" => "Dra.Brinquedos",  "data" => "2026-10-25", "hora" => "13:00", "status" => "agendado"],
    ["id" => 5, "pet" => "Mia (Gato)",  "tutor" => "Juliana Ferreira",  "servico" => "Vacinação",  "veterinario" => "Dra.Brinquedos",  "data" => "2026-10-23", "hora" => "14:30", "status" => "concluido"],
    ["id" => 6, "pet" => "Nina (Poodle)",  "tutor" => "Lucas Martins",  "servico" => "Consulta",  "veterinario" => "Dra.Brinquedos",  "data" => "2026-10-24", "hora" => "16:00", "status" => "agendado"]   
];

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['consultas']) || !is_array($_SESSION['consultas'])) {
    $_SESSION['consultas'] = $consultasIniciais;
}
$consultas =& $_SESSION['consultas'];
?>

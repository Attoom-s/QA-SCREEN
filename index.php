<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$nombreUsuario = $_SESSION['nombre'] ?? 'Tester QA';
$rolUsuario = $_SESSION['rol'] ?? 'CLIENTE';
?>
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QA System - Dashboard Ejecutivo NoSQL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { brand: { purple: '#6b21a8', purpleDark: '#4c1d95', green: '#15803d' } },
                    fontFamily: { sans: ['Inter', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] }
                }
            }
        }
    </script>
    <style>
        .ascii-card { font-family: 'JetBrains Mono', monospace; white-space: pre; line-height: 1.25; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-30 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-purple to-brand-purpleDark text-white shadow-lg border border-amber-500">
                        <i class="fa-solid fa-chart-line text-xl text-amber-300"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 dark:text-white">QA SYSTEM</h1>
                        <p class="text-xs text-brand-purple dark:text-purple-400 font-medium">Monitoreo en tiempo real de pruebas, cobertura e incidentes</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right text-xs">
                        <div class="font-bold"><?= htmlspecialchars($nombreUsuario) ?></div>
                        <div class="text-brand-purple font-mono"><?= htmlspecialchars($rolUsuario) ?></div>
                    </div>
                    <a href="logout.php" class="px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition flex items-center space-x-1.5 shadow">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Salir</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- WORKSPACE -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        
        <!-- SIDEBAR DE NAVEGACIÓN -->
        <aside class="w-full md:w-64 flex-shrink-0 no-print">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700 space-y-1 sticky top-24 shadow-sm">
                <button onclick="switchTab('dashboard')" id="nav-dashboard" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded bg-brand-purple text-white"><i class="fa-solid fa-gauge-high w-5"></i> Panel General</button>
                <div class="pt-2 pb-1 border-t border-slate-200 dark:border-slate-700 text-[10px] font-bold text-slate-400 uppercase">Formularios de Prueba</div>
                <button onclick="switchTab('f1')" id="nav-f1" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-vial w-5"></i> F1: Casos de Prueba</button>
                <button onclick="switchTab('f2')" id="nav-f2" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-table w-5"></i> F2: Equivalencias</button>
                <button onclick="switchTab('f3')" id="nav-f3" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-arrows-left-right w-5"></i> F3: Valor Límite</button>
                <button onclick="switchTab('f4')" id="nav-f4" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-sitemap w-5"></i> F4: RBAC</button>
                <button onclick="switchTab('f5')" id="nav-f5" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-code-branch w-5"></i> F5: CFG & Cobertura</button>
                <button onclick="switchTab('f6')" id="nav-f6" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-clipboard-list w-5"></i> F6: Plan de Pruebas</button>
                <button onclick="switchTab('f7')" id="nav-f7" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-calculator w-5"></i> F7: Rúbrica</button>
                <button onclick="switchTab('f8')" id="nav-f8" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-user-check w-5"></i> F8: Auto/Coevaluación</button>
                <button onclick="switchTab('f9')" id="nav-f9" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-folder-open w-5"></i> F9: Mockups</button>
                <button onclick="switchTab('f10')" id="nav-f10" class="nav-btn w-full text-left px-3 py-2 text-xs font-bold rounded text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700"><i class="fa-solid fa-bug w-5"></i> F10: Reporte Bugs</button>
            </div>
        </aside>

        <!-- MAIN VIEWS -->
        <main class="flex-1 min-w-0">
            
            <!-- PANEL GENERAL / DASHBOARD RESUMEN -->
            <section id="tab-dashboard" class="tab-content block space-y-6">
                
                <!-- KPI CARDS METRICS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center space-x-4">
                        <div class="p-3 bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300 rounded-xl">
                            <i class="fa-solid fa-vial text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase">Casos Totales</div>
                            <div id="stat-total-cases" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</div>
                            <div class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-check"></i> Sincronizados JSON</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center space-x-4">
                        <div class="p-3 bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 rounded-xl">
                            <i class="fa-solid fa-circle-check text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase">Tasa de Éxito</div>
                            <div id="stat-success-rate" class="text-2xl font-extrabold text-emerald-600">0%</div>
                            <div class="text-[10px] text-slate-400">Pruebas en estado OK</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center space-x-4">
                        <div class="p-3 bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 rounded-xl">
                            <i class="fa-solid fa-layer-group text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase">Caja Negra / Blanca</div>
                            <div id="stat-tech-ratio" class="text-xl font-extrabold text-slate-800 dark:text-white">0 / 0</div>
                            <div class="text-[10px] text-indigo-500 font-semibold">Técnicas aplicadas</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center space-x-4">
                        <div class="p-3 bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300 rounded-xl">
                            <i class="fa-solid fa-bug text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase">Bugs Abiertos</div>
                            <div id="stat-open-bugs" class="text-2xl font-extrabold text-red-600">0</div>
                            <div class="text-[10px] text-red-500 font-semibold">Incidentes detectados</div>
                        </div>
                    </div>
                </div>

                <!-- BARRAS DE PROGRESO Y COBERTURA -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-white flex items-center justify-between">
                            <span><i class="fa-solid fa-chart-simple text-brand-purple mr-2"></i> Cobertura de Pruebas</span>
                            <span class="text-xs font-mono text-purple-600">100% Requisitos</span>
                        </h3>
                        
                        <div class="space-y-3 text-xs">
                            <div>
                                <div class="flex justify-between mb-1 font-semibold">
                                    <span>Pruebas de Caja Negra (Funcional)</span>
                                    <span id="blackbox-pct">0%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden">
                                    <div id="bar-blackbox" class="bg-brand-purple h-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1 font-semibold">
                                    <span>Pruebas de Caja Blanca (Estructural)</span>
                                    <span id="whitebox-pct">0%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden">
                                    <div id="bar-whitebox" class="bg-amber-500 h-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-white flex items-center justify-between">
                            <span><i class="fa-solid fa-shield-halved text-emerald-600 mr-2"></i> Calidad de Autoevaluación y Rúbrica</span>
                            <span class="text-xs font-mono text-emerald-600">30 / 30 Pts</span>
                        </h3>
                        <p class="text-xs text-slate-500">Evaluación sumativa de cumplimiento de la Unidad III. Todos los criterios cumplen el estándar excelente.</p>
                        <div class="flex items-center space-x-3 bg-emerald-50 dark:bg-emerald-950/40 p-3 rounded-lg border border-emerald-200 dark:border-emerald-800">
                            <i class="fa-solid fa-award text-emerald-600 text-2xl"></i>
                            <div class="text-xs text-emerald-800 dark:text-emerald-300">
                                <strong>Estado de Aprobación: EXCELENTE</strong><br>
                                Cobertura >90%, documentación completa y herramientas integradas.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DE ÚLTIMOS CASOS Y BUGS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-bold text-xs uppercase text-slate-500">Casos Recientes (`casos_prueba.json`)</h3>
                            <button onclick="switchTab('f1')" class="text-xs text-brand-purple font-bold">Ver todos →</button>
                        </div>
                        <ul id="recent-cases-list" class="divide-y text-xs"></ul>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-bold text-xs uppercase text-slate-500">Reportes de Bugs (`bugs.json`)</h3>
                            <button onclick="switchTab('f10')" class="text-xs text-red-600 font-bold">Ver todos →</button>
                        </div>
                        <ul id="recent-bugs-list" class="divide-y text-xs"></ul>
                    </div>
                </div>

            </section>

            <!-- F1: CASOS DE PRUEBA CON FILTRO -->
            <section id="tab-f1" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 shadow-sm">
                    <div>
                        <h2 class="font-bold text-sm">F1: Casos de Prueba (`casos_prueba.json`)</h2>
                        <p class="text-xs text-slate-500">Gestión e inspección NoSQL con filtrado por técnica</p>
                    </div>
                    
                    <div class="flex items-center space-x-3 w-full sm:w-auto">
                        <div class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600">
                            <i class="fa-solid fa-filter text-brand-purple text-xs"></i>
                            <select id="filter-technique" onchange="filterTestCases()" class="bg-transparent text-xs font-bold text-slate-700 dark:text-slate-200 focus:outline-none cursor-pointer">
                                <option value="TODAS">Todas las Técnicas</option>
                                <option value="Caja Negra">Caja Negra</option>
                                <option value="Caja Blanca">Caja Blanca</option>
                            </select>
                        </div>

                        <button onclick="openModal('modal-test-case')" class="px-3 py-1.5 bg-brand-purple hover:bg-brand-purpleDark text-white text-xs font-bold rounded-lg transition shadow">
                            <i class="fa-solid fa-plus mr-1"></i> Nuevo Caso
                        </button>
                    </div>
                </div>

                <div class="bg-slate-950 text-emerald-400 p-4 rounded-lg overflow-x-auto text-xs font-mono border border-slate-800 shadow-inner">
                    <pre id="ascii-card-preview" class="ascii-card">Seleccione un caso para previsualizar la tarjeta ASCII...</pre>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl border overflow-hidden p-4 shadow-sm">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr>
                                <th class="p-2">ID</th>
                                <th class="p-2">Módulo</th>
                                <th class="p-2">Técnica</th>
                                <th class="p-2">Objetivo</th>
                                <th class="p-2 text-center">Estado</th>
                                <th class="p-2 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="test-cases-tbody" class="divide-y divide-slate-200 dark:divide-slate-700"></tbody>
                    </table>
                </div>
            </section>

            <!-- F2: CLASES DE EQUIVALENCIA -->
            <section id="tab-f2" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F2: Clases de Equivalencia (`equivalencias.json`)</h2>
                    <table class="w-full text-left text-xs border">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr><th class="p-2">Campo</th><th class="p-2">Clase Válida</th><th class="p-2">Clases Inválidas</th><th class="p-2">Representativos</th></tr>
                        </thead>
                        <tbody id="equivalence-tbody" class="divide-y"></tbody>
                    </table>
                </div>
            </section>

            <!-- F3: VALOR LÍMITE -->
            <section id="tab-f3" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F3: Análisis de Valor Límite (`limites.json`)</h2>
                    <table class="w-full text-left text-xs border">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr><th class="p-2">Campo</th><th class="p-2">Rango</th><th class="p-2">Min</th><th class="p-2">Max</th><th class="p-2">Valores Probar</th></tr>
                        </thead>
                        <tbody id="boundary-tbody" class="divide-y"></tbody>
                    </table>
                </div>
            </section>

            <!-- F4: TABLA DE DECISIONES RBAC -->
            <section id="tab-f4" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F4: Control de Acceso RBAC</h2>
                    <p class="text-xs text-slate-500">Modelado en tablas de decisión para perfiles ADMIN y CLIENTE con almacenamiento en archivos JSON.</p>
                </div>
            </section>

            <!-- F5: COBERTURA Y CFG -->
            <section id="tab-f5" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F5: Grafo CFG y Complejidad Ciclomática</h2>
                    <div class="bg-slate-900 p-4 rounded text-xs font-mono text-amber-400">
<pre>
  ( 1: Inicio ) ──► { 2: $query != ""? } ── No ──► [ 3: Error ]
                         │
                        Sí ──► [ 4: Procesar ] ──► ( 5: Fin )
</pre>
                    </div>
                </div>
            </section>

            <!-- F6: PLAN DE PRUEBAS -->
            <section id="tab-f6" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-2">F6: Plan de Pruebas del Proyecto</h2>
                    <p class="text-xs text-slate-500">Documento de arquitectura integral con persistencia NoSQL para motor de búsqueda.</p>
                </div>
            </section>

            <!-- F7: RÚBRICA -->
            <section id="tab-f7" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F7: Rúbrica de Evaluación (`rubrica.json`)</h2>
                    <table class="w-full text-left text-xs border">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr><th class="p-2">Criterio</th><th class="p-2">Excelente (5)</th><th class="p-2">Bueno (4)</th><th class="p-2">Regular (3)</th><th class="p-2">Deficiente (1-2)</th></tr>
                        </thead>
                        <tbody id="rubric-tbody" class="divide-y"></tbody>
                    </table>
                </div>
            </section>

            <!-- F8: AUTO/COEVALUACIÓN -->
            <section id="tab-f8" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-3">F8: Autoevaluación y Coevaluación (`evaluacion.json`)</h2>
                    <table class="w-full text-left text-xs border">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr><th class="p-2">Aspecto</th><th class="p-2 text-center">Auto</th><th class="p-2 text-center">Coeval</th><th class="p-2">Comentarios</th></tr>
                        </thead>
                        <tbody id="eval-tbody" class="divide-y"></tbody>
                    </table>
                </div>
            </section>

            <!-- F9: MOCKUPS -->
            <section id="tab-f9" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border shadow-sm">
                    <h2 class="font-bold text-sm mb-2">F9: Portafolio de Mockups</h2>
                    <p class="text-xs text-slate-500">Simulación interactiva de vistas del sistema.</p>
                </div>
            </section>

            <!-- F10: BUGS -->
            <section id="tab-f10" class="tab-content hidden space-y-4">
                <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border flex justify-between items-center shadow-sm">
                    <h2 class="font-bold text-sm">F10: Registro de Defectos (`bugs.json`)</h2>
                    <button onclick="openModal('modal-bug')" class="px-3 py-1.5 bg-red-600 text-white text-xs font-bold rounded">Reportar Bug</button>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl border overflow-hidden p-4 shadow-sm">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 dark:bg-slate-700 uppercase font-bold">
                            <tr><th class="p-2">ID</th><th class="p-2">Título</th><th class="p-2">Módulo</th><th class="p-2">Severidad</th><th class="p-2">Estado</th></tr>
                        </thead>
                        <tbody id="bugs-tbody" class="divide-y"></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- MODAL: AGREGAR CASO DE PRUEBA COMPLETO (F1) -->
    <div id="modal-test-case" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-xl w-full border border-slate-700 overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-4 border-b border-slate-700 bg-brand-purple text-white flex justify-between items-center">
                <h3 class="font-bold text-sm">Registrar Nuevo Caso de Prueba (NoSQL Completo)</h3>
                <button onclick="closeModal('modal-test-case')" class="text-white hover:text-slate-200"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-add-test" onsubmit="saveTestCaseNoSQL(event)" class="p-5 overflow-y-auto space-y-3 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">ID del Caso:</label>
                        <input type="text" id="inp-tc-id" required value="CP-009" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Módulo / Funcionalidad:</label>
                        <input type="text" id="inp-tc-module" required placeholder="ej. login.php" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Técnica:</label>
                        <select id="inp-tc-technique" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                            <option value="Caja Negra">Caja Negra</option>
                            <option value="Caja Blanca">Caja Blanca</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Sub-técnica:</label>
                        <input type="text" id="inp-tc-subtechnique" required placeholder="ej. Partición de equivalencia" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300">Objetivo:</label>
                    <input type="text" id="inp-tc-target" required placeholder="Describa el objetivo principal" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Precondiciones:</label>
                        <input type="text" id="inp-tc-pre" required placeholder="ej. Sesión activa" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Datos de Entrada:</label>
                        <input type="text" id="inp-tc-data" required placeholder="ej. Usuario='admin'" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300">Pasos de Ejecución:</label>
                    <textarea id="inp-tc-steps" rows="2" required placeholder="1. Abrir vista, 2. Enviar datos..." class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Resultado Esperado:</label>
                        <input type="text" id="inp-tc-expected" required class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Resultado Obtenido:</label>
                        <input type="text" id="inp-tc-obtained" required class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Estado:</label>
                        <select id="inp-tc-status" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600 font-bold">
                            <option value="Éxito">✅ Éxito</option>
                            <option value="Fallo">❌ Fallo</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Evidencia (Nombre de archivo):</label>
                        <input type="text" id="inp-tc-evidence" value="EVID-CP-NEW.PNG" class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600">
                    </div>
                </div>
                <div class="pt-3 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('modal-test-case')" class="px-3 py-1.5 bg-slate-700 text-slate-200 rounded font-semibold">Cancelar</button>
                    <button type="submit" class="px-4 py-1.5 bg-brand-purple text-white rounded font-semibold hover:bg-brand-purpleDark">Guardar en Colección NoSQL</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: REPORTAR INCIDENTE / BUG (F10) -->
    <div id="modal-bug" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-lg w-full border border-slate-700 overflow-hidden">
            <div class="p-4 border-b border-slate-700 bg-red-600 text-white flex justify-between items-center">
                <h3 class="font-bold text-sm">Reportar Incidente / Defecto (NoSQL)</h3>
                <button onclick="closeModal('modal-bug')" class="text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="form-add-bug" onsubmit="saveBugNoSQL(event)" class="p-5 space-y-3 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">ID Bug:</label>
                        <input type="text" id="inp-bug-id" required value="BUG-003" class="w-full p-2 border rounded dark:bg-slate-700">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Módulo Afectado:</label>
                        <input type="text" id="inp-bug-module" required placeholder="ej. historial.php" class="w-full p-2 border rounded dark:bg-slate-700">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300">Título del Defecto:</label>
                    <input type="text" id="inp-bug-title" required class="w-full p-2 border rounded dark:bg-slate-700">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Severidad:</label>
                        <select id="inp-bug-severity" class="w-full p-2 border rounded dark:bg-slate-700">
                            <option value="Crítica">Crítica</option>
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 dark:text-slate-300">Prioridad:</label>
                        <select id="inp-bug-priority" class="w-full p-2 border rounded dark:bg-slate-700">
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300">Descripción:</label>
                    <textarea id="inp-bug-desc" rows="2" required class="w-full p-2 border rounded dark:bg-slate-700"></textarea>
                </div>
                <div class="pt-3 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('modal-bug')" class="px-3 py-1.5 bg-slate-700 text-slate-200 rounded font-semibold">Cancelar</button>
                    <button type="submit" class="px-4 py-1.5 bg-red-600 text-white rounded font-semibold hover:bg-red-700">Guardar Bug en NoSQL</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT DE SINCRONIZACIÓN Y DASHBOARD -->
    <script>
        let testCases = [];
        let equivalenceData = [];
        let boundaryData = [];
        let rubricItems = [];
        let evalItems = [];
        let bugsData = [];

        window.onload = async function() {
            await loadAllNoSQLData();
        };

        async function loadAllNoSQLData() {
            try {
                const [tcRes, eqRes, boRes, ruRes, evRes, bgRes] = await Promise.all([
                    fetch('api.php?action=get_casos'),
                    fetch('api.php?action=get_equivalencias'),
                    fetch('api.php?action=get_limites'),
                    fetch('api.php?action=get_rubrica'),
                    fetch('api.php?action=get_evaluacion'),
                    fetch('api.php?action=get_bugs')
                ]);

                testCases = await tcRes.json();
                equivalenceData = await eqRes.json();
                boundaryData = await boRes.json();
                rubricItems = await ruRes.json();
                evalItems = await evRes.json();
                bugsData = await bgRes.json();

                updateDashboardMetrics();
                renderTestCases();
                renderEquivalenceTable();
                renderBoundaryTable();
                renderRubricTable();
                renderEvalTable();
                renderBugsTable();
            } catch (err) {
                console.error("Error cargando colecciones NoSQL:", err);
            }
        }

        function updateDashboardMetrics() {
            // Métricas calculadas
            const total = testCases.length;
            const successCount = testCases.filter(c => c.status === 'Éxito').length;
            const successPct = total > 0 ? Math.round((successCount / total) * 100) : 0;
            
            const blackBoxCount = testCases.filter(c => c.technique === 'Caja Negra').length;
            const whiteBoxCount = testCases.filter(c => c.technique === 'Caja Blanca').length;

            const blackBoxPct = total > 0 ? Math.round((blackBoxCount / total) * 100) : 0;
            const whiteBoxPct = total > 0 ? Math.round((whiteBoxCount / total) * 100) : 0;

            const openBugs = bugsData.filter(b => b.status === 'Abierto').length;

            // Renderizado en KPI Cards
            document.getElementById('stat-total-cases').innerText = total;
            document.getElementById('stat-success-rate').innerText = `${successPct}%`;
            document.getElementById('stat-tech-ratio').innerText = `${blackBoxCount} / ${whiteBoxCount}`;
            document.getElementById('stat-open-bugs').innerText = openBugs;

            // Barras de progreso
            document.getElementById('blackbox-pct').innerText = `${blackBoxPct}% (${blackBoxCount})`;
            document.getElementById('bar-blackbox').style.width = `${blackBoxPct}%`;

            document.getElementById('whitebox-pct').innerText = `${whiteBoxPct}% (${whiteBoxCount})`;
            document.getElementById('bar-whitebox').style.width = `${whiteBoxPct}%`;

            // Listas recientes
            const recentCasesUl = document.getElementById('recent-cases-list');
            recentCasesUl.innerHTML = '';
            testCases.slice(-4).reverse().forEach(c => {
                recentCasesUl.innerHTML += `
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <span class="font-bold text-brand-purple">${c.id}</span> - <span class="font-medium">${c.module}</span>
                            <div class="text-[10px] text-slate-400">${c.target}</div>
                        </div>
                        <span class="px-2 py-0.5 text-[10px] bg-emerald-100 text-emerald-800 rounded font-bold">${c.status}</span>
                    </li>`;
            });

            const recentBugsUl = document.getElementById('recent-bugs-list');
            recentBugsUl.innerHTML = '';
            bugsData.slice(-4).reverse().forEach(b => {
                recentBugsUl.innerHTML += `
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <span class="font-bold text-red-600">${b.id}</span> - <span class="font-medium">${b.title}</span>
                            <div class="text-[10px] text-slate-400">${b.module} | Sev: ${b.severity}</div>
                        </div>
                        <span class="px-2 py-0.5 text-[10px] bg-slate-200 text-slate-800 rounded font-bold">${b.status}</span>
                    </li>`;
            });
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(`tab-${tabId}`).classList.remove('hidden');
            document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('bg-brand-purple', 'text-white'));
            document.getElementById(`nav-${tabId}`).classList.add('bg-brand-purple', 'text-white');
        }

        async function saveTestCaseNoSQL(e) {
            e.preventDefault();
            const newTc = {
                id: document.getElementById('inp-tc-id').value,
                module: document.getElementById('inp-tc-module').value,
                technique: document.getElementById('inp-tc-technique').value,
                subtechnique: document.getElementById('inp-tc-subtechnique').value,
                target: document.getElementById('inp-tc-target').value,
                preconditions: document.getElementById('inp-tc-pre').value,
                inputData: document.getElementById('inp-tc-data').value,
                steps: document.getElementById('inp-tc-steps').value,
                expected: document.getElementById('inp-tc-expected').value,
                obtained: document.getElementById('inp-tc-obtained').value,
                status: document.getElementById('inp-tc-status').value,
                observations: 'Registrado dinámicamente en NoSQL',
                evidence: document.getElementById('inp-tc-evidence').value
            };

            await fetch('api.php?action=save_caso', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(newTc)
            });

            closeModal('modal-test-case');
            const res = await fetch('api.php?action=get_casos');
            testCases = await res.json();
            updateDashboardMetrics();
            renderTestCases();
        }

        async function saveBugNoSQL(e) {
            e.preventDefault();
            const newBug = {
                id: document.getElementById('inp-bug-id').value,
                date: new Date().toLocaleDateString(),
                title: document.getElementById('inp-bug-title').value,
                module: document.getElementById('inp-bug-module').value,
                severity: document.getElementById('inp-bug-severity').value,
                priority: document.getElementById('inp-bug-priority').value,
                status: "Abierto",
                steps: "1. Reproducir escenario de fallo",
                expected: "Comportamiento estándar del sistema",
                obtained: document.getElementById('inp-bug-desc').value,
                assigned: "Equipo QA"
            };

            await fetch('api.php?action=save_bug', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(newBug)
            });

            closeModal('modal-bug');
            const res = await fetch('api.php?action=get_bugs');
            bugsData = await res.json();
            updateDashboardMetrics();
            renderBugsTable();
        }

        async function deleteTestCaseNoSQL(id) {
            await fetch(`api.php?action=delete_caso&id=${id}`);
            const res = await fetch('api.php?action=get_casos');
            testCases = await res.json();
            updateDashboardMetrics();
            renderTestCases();
        }

        function getFilteredCases() {
            const filterValue = document.getElementById('filter-technique').value;
            if (filterValue === 'TODAS') {
                return testCases;
            }
            return testCases.filter(tc => tc.technique === filterValue);
        }

        function filterTestCases() {
            renderTestCases();
        }

        function renderTestCases(filteredList = null) {
            const listToRender = filteredList || getFilteredCases();
            const tbody = document.getElementById('test-cases-tbody');
            tbody.innerHTML = '';

            if (listToRender.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-slate-400 italic">No se encontraron casos de prueba para el filtro seleccionado.</td></tr>`;
                document.getElementById('ascii-card-preview').innerText = "No hay datos para mostrar con este filtro.";
                return;
            }

            listToRender.forEach(tc => {
                const badgeColor = tc.technique === 'Caja Negra' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300';
                
                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer transition" onclick="selectTestCaseForASCII('${tc.id}')">
                        <td class="p-2 font-mono font-bold text-brand-purple">${tc.id}</td>
                        <td class="p-2 font-medium">${tc.module}</td>
                        <td class="p-2"><span class="px-2 py-0.5 rounded-md text-[10px] font-bold ${badgeColor}">${tc.technique}</span></td>
                        <td class="p-2">${tc.target}</td>
                        <td class="p-2 text-center"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold text-[10px]">✅ ${tc.status}</span></td>
                        <td class="p-2 text-right">
                            <button onclick="event.stopPropagation(); deleteTestCaseNoSQL('${tc.id}')" class="text-red-500 hover:text-red-700 p-1"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>`;
            });

            selectTestCaseForASCII(listToRender[0].id);
        }

        function selectTestCaseForASCII(id) {
            const tc = testCases.find(c => c.id === id);
            if (!tc) return;
            const ascii = `
┌────────────────────────────────────────────────────────────────────────┐
│ REGISTRO DE CASO DE PRUEBA (NOSQL JSON PERSISTED)                     │
├────────────────────────────────────────────────────────────────────────┤
│ ID: ${tc.id.padEnd(20)} Módulo: ${tc.module.padEnd(26)} │
│ Técnica: ${tc.technique.padEnd(20)} Sub-técnica: ${tc.subtechnique.padEnd(20)} │
│ Objetivo: ${tc.target.padEnd(60)} │
│ Precondiciones: ${(tc.preconditions || '').padEnd(54)} │
│ Datos de Entrada: ${(tc.inputData || '').padEnd(52)} │
│ Pasos:                                                                 │
│   ${(tc.steps || '').padEnd(67)} │
│ Resultado Esperado: ${(tc.expected || '').padEnd(50)} │
│ Resultado Obtenido: ${(tc.obtained || '').padEnd(50)} │
│ Estado: [${tc.status === 'Éxito' ? 'X' : ' '}] Éxito  [${tc.status === 'Fallo' ? 'X' : ' '}] Fallo                                           │
└────────────────────────────────────────────────────────────────────────┘`;
            document.getElementById('ascii-card-preview').innerText = ascii;
        }

        function renderEquivalenceTable() {
            const tbody = document.getElementById('equivalence-tbody');
            tbody.innerHTML = '';
            equivalenceData.forEach(row => {
                tbody.innerHTML += `<tr><td class="p-2 font-bold">${row.field}</td><td class="p-2 text-emerald-600">${row.valid}</td><td class="p-2 text-red-500">${row.invalid}</td><td class="p-2 font-mono">${row.rep}</td></tr>`;
            });
        }

        function renderBoundaryTable() {
            const tbody = document.getElementById('boundary-tbody');
            tbody.innerHTML = '';
            boundaryData.forEach(row => {
                tbody.innerHTML += `<tr><td class="p-2 font-bold">${row.field}</td><td class="p-2 font-mono">${row.range}</td><td class="p-2 font-mono">${row.min}</td><td class="p-2 font-mono">${row.max}</td><td class="p-2 font-mono text-amber-600">${row.testValues}</td></tr>`;
            });
        }

        function renderRubricTable() {
            const tbody = document.getElementById('rubric-tbody');
            tbody.innerHTML = '';
            rubricItems.forEach(item => {
                tbody.innerHTML += `<tr><td class="p-2 font-bold">${item.name}</td><td class="p-2 text-[11px]">${item.excelente}</td><td class="p-2 text-[11px]">${item.bueno}</td><td class="p-2 text-[11px]">${item.regular}</td><td class="p-2 text-[11px]">${item.deficiente}</td></tr>`;
            });
        }

        function renderEvalTable() {
            const tbody = document.getElementById('eval-tbody');
            tbody.innerHTML = '';
            evalItems.forEach(item => {
                tbody.innerHTML += `<tr><td class="p-2 font-semibold">${item.aspect}</td><td class="p-2 text-center font-bold text-brand-purple">${item.auto}.0</td><td class="p-2 text-center font-bold text-brand-purple">${item.co}.0</td><td class="p-2 text-slate-500">${item.comment}</td></tr>`;
            });
        }

        function renderBugsTable() {
            const tbody = document.getElementById('bugs-tbody');
            tbody.innerHTML = '';
            bugsData.forEach(bug => {
                tbody.innerHTML += `<tr><td class="p-2 font-mono font-bold text-red-500">${bug.id}</td><td class="p-2">${bug.title}</td><td class="p-2">${bug.module}</td><td class="p-2">${bug.severity}</td><td class="p-2"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold">${bug.status}</span></td></tr>`;
            });
        }

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</body>
</html>
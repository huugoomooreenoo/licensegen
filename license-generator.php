<?php
// Variables por defecto
$selectedType = isset($_GET['type']) ? $_GET['type'] : 'MIT';
$projectName = isset($_POST['projectName']) ? htmlspecialchars($_POST['projectName']) : '';
$copyrightHolder = isset($_POST['copyrightHolder']) ? htmlspecialchars($_POST['copyrightHolder']) : '';
$copyrightYear = isset($_POST['copyrightYear']) ? htmlspecialchars($_POST['copyrightYear']) : date('Y');
$description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
$generatedLicense = '';

// Plantillas de licencias
$licenses = [
    'MIT' => 'MIT License

Copyright (c) {{year}} {{holder}}

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.',

    'Apache' => 'Apache License
Version 2.0, January 2004
http://www.apache.org/licenses/

Copyright (c) {{year}} {{holder}}

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.',

    'GPL' => 'GNU GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) {{year}} {{holder}}

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.',

    'BSD' => 'BSD 3-Clause License

Copyright (c) {{year}}, {{holder}}
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its
   contributors may be used to endorse or promote products derived from
   this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.',

    'Custom' => 'LICENSE AGREEMENT

Project: {{name}}
Copyright (c) {{year}} {{holder}}

{{description}}

All rights reserved.'
];

// Procesar generación de licencia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $selectedType = $_POST['licenseType'] ?? 'MIT';
    $projectName = $_POST['projectName'] ?? 'Mi Proyecto';
    $copyrightHolder = $_POST['copyrightHolder'] ?? 'El Autor';
    $copyrightYear = $_POST['copyrightYear'] ?? date('Y');
    $description = $_POST['description'] ?? '(Sin descripción)';

    if (isset($licenses[$selectedType])) {
        $generatedLicense = $licenses[$selectedType];
        $generatedLicense = str_replace('{{year}}', $copyrightYear, $generatedLicense);
        $generatedLicense = str_replace('{{holder}}', $copyrightHolder, $generatedLicense);
        $generatedLicense = str_replace('{{name}}', $projectName, $generatedLicense);
        $generatedLicense = str_replace('{{description}}', $description, $generatedLicense);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Licencias - Hugo Moreno Pro</title>
    <meta name="description" content="Genera licencias de software personalizadas para tus proyectos">
    <link rel="stylesheet" href="assets/css/style.css">
         <style>
         .license-container {
             max-width: 900px;
             margin: 6rem auto 4rem;
             padding: var(--spacing-md);
             position: relative;
             z-index: 10;
         }
         
         #particlesCanvas {
             z-index: 0 !important;
         }
         
         form, .license-preview, .license-form {
             position: relative;
             z-index: 10;
         }
        
        .license-header {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }
        
        .license-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: var(--spacing-sm);
            font-family: var(--font-mono);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .license-subtitle {
            color: var(--color-text-dim);
            font-size: 1.1rem;
        }
        
        .license-form {
            background: var(--color-surface);
            border: 1px solid var(--neon-blue);
            border-radius: 12px;
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.2);
        }
        
        .form-group {
            margin-bottom: var(--spacing-md);
        }
        
        .form-group label {
            display: block;
            color: var(--neon-cyan);
            font-family: var(--font-mono);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-xs);
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: var(--spacing-sm);
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--neon-blue);
            border-radius: 4px;
            color: var(--color-text);
            font-family: var(--font-sans);
            transition: var(--transition-fast);
            box-sizing: border-box;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .license-preview {
            background: var(--color-surface);
            border: 1px solid var(--neon-green);
            border-radius: 12px;
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 0 30px rgba(57, 255, 20, 0.2);
        }
        
        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
            padding-bottom: var(--spacing-sm);
            border-bottom: 1px solid var(--neon-green);
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }
        
        .preview-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--neon-green);
            font-family: var(--font-mono);
        }
        
        .preview-content {
            color: var(--color-text);
            line-height: 1.8;
            font-family: var(--font-mono);
            font-size: 0.9rem;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 500px;
            overflow-y: auto;
            padding: var(--spacing-sm);
            background: rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }
        
        .copy-btn, .download-btn {
            background: var(--gradient-secondary);
            border: none;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: 4px;
            color: var(--color-bg);
            font-family: var(--font-mono);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-fast);
            text-decoration: none;
            display: inline-block;
        }
        
        .copy-btn:hover, .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--glow-green);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--neon-blue);
            text-decoration: none;
            font-family: var(--font-mono);
            transition: var(--transition-fast);
            margin-bottom: var(--spacing-md);
        }
        
        .back-link:hover {
            color: var(--neon-cyan);
            text-shadow: var(--glow-blue);
        }
        
        .license-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }
        
        .license-type-radio {
            display: none;
        }
        
        .license-type-label {
            display: block;
            text-align: center;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid var(--neon-blue);
            padding: var(--spacing-sm);
            border-radius: 4px;
            color: var(--neon-blue);
            font-family: var(--font-mono);
            cursor: pointer;
            transition: var(--transition-fast);
        }
        
        .license-type-label:hover {
            background: rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .license-type-radio:checked + .license-type-label {
            background: var(--neon-blue);
            color: var(--color-bg);
        }
        
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--neon-green);
            color: var(--color-bg);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 4px;
            font-family: var(--font-mono);
            box-shadow: var(--glow-green);
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition-normal);
            z-index: 1000;
            pointer-events: none;
        }
        
        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Canvas para partículas de fondo -->
    <canvas id="particlesCanvas"></canvas>

    <div class="license-container">
        <a href="index.php" class="back-link">← Volver al Portfolio</a>
        
        <div class="license-header">
            <h1 class="license-title">📄 Generador de Licencias</h1>
            <p class="license-subtitle">Crea licencias personalizadas para tus proyectos</p>
        </div>

        <form method="POST" class="license-form">
            <div class="form-group">
                <label>Tipo de Licencia</label>
                <div class="license-types">
                    <input type="radio" name="licenseType" value="MIT" id="type-mit" class="license-type-radio" <?php echo $selectedType === 'MIT' ? 'checked' : ''; ?>>
                    <label for="type-mit" class="license-type-label">MIT</label>
                    
                    <input type="radio" name="licenseType" value="Apache" id="type-apache" class="license-type-radio" <?php echo $selectedType === 'Apache' ? 'checked' : ''; ?>>
                    <label for="type-apache" class="license-type-label">Apache 2.0</label>
                    
                    <input type="radio" name="licenseType" value="GPL" id="type-gpl" class="license-type-radio" <?php echo $selectedType === 'GPL' ? 'checked' : ''; ?>>
                    <label for="type-gpl" class="license-type-label">GPL v3</label>
                    
                    <input type="radio" name="licenseType" value="BSD" id="type-bsd" class="license-type-radio" <?php echo $selectedType === 'BSD' ? 'checked' : ''; ?>>
                    <label for="type-bsd" class="license-type-label">BSD 3-Clause</label>
                    
                    <input type="radio" name="licenseType" value="Custom" id="type-custom" class="license-type-radio" <?php echo $selectedType === 'Custom' ? 'checked' : ''; ?>>
                    <label for="type-custom" class="license-type-label">Personalizada</label>
                </div>
            </div>

            <div class="form-group">
                <label for="projectName">Nombre del Proyecto</label>
                <input type="text" id="projectName" name="projectName" placeholder="Mi Proyecto Increíble" value="<?php echo $projectName; ?>" required>
            </div>

            <div class="form-group">
                <label for="copyrightHolder">Propietario de los Derechos</label>
                <input type="text" id="copyrightHolder" name="copyrightHolder" placeholder="Tu Nombre o Empresa" value="<?php echo $copyrightHolder; ?>" required>
            </div>

            <div class="form-group">
                <label for="copyrightYear">Año de Copyright</label>
                <input type="number" id="copyrightYear" name="copyrightYear" value="<?php echo $copyrightYear; ?>" min="1900" max="2100" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción (opcional)</label>
                <textarea id="description" name="description" placeholder="Breve descripción de tu proyecto..."><?php echo $description; ?></textarea>
            </div>

            <button type="submit" name="generate" class="btn btn-primary" style="width: 100%;">🎲 Generar Licencia</button>
        </form>

        <?php if ($generatedLicense): ?>
        <div class="license-preview" id="licensePreview">
            <div class="preview-header">
                <h3 class="preview-title">Previsualización</h3>
                <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
                    <button class="copy-btn" onclick="copyLicense()">📋 Copiar</button>
                    <a href="data:text/plain;charset=utf-8,<?php echo urlencode($generatedLicense); ?>" download="LICENSE" class="download-btn">💾 Descargar</a>
                </div>
            </div>
            <div class="preview-content" id="previewContent"><?php echo htmlspecialchars($generatedLicense); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <div class="notification" id="notification">✓ Licencia copiada al portapapeles</div>

    <!-- Scripts -->
    <script src="assets/js/particles.js"></script>
    <script>
        function copyLicense() {
            const content = document.getElementById('previewContent').textContent;
            navigator.clipboard.writeText(content).then(() => {
                showNotification();
            }).catch(() => {
                // Fallback para navegadores antiguos
                const textArea = document.createElement('textarea');
                textArea.value = content;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification();
            });
        }

        function showNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 2000);
        }

        // Auto-scroll a la previsualización después de generar
        <?php if ($generatedLicense): ?>
        document.getElementById('licensePreview').scrollIntoView({ behavior: 'smooth', block: 'start' });
        <?php endif; ?>
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYM - CRUD Instructores</title>
</head>
<body>
    <div class="container">
        <h1>🏋️‍♂️ Sistema de Gestión de Instructores</h1>
        <p class="subtitle">CRUD completo - Horarios y Clientes asignados</p>

        <!-- Estadísticas -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number" id="totalInstructores">0</div>
                <div>Instructores</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalHorarios">0</div>
                <div>Horarios Totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalClientesAsignados">0</div>
                <div>Clientes Atendidos</div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="form-section">
            <h2 id="formTitle">Registrar Nuevo Instructor</h2>
            <form id="instructorForm">
                <input type="hidden" id="instructorId">
                
                <div class="row">
                    <div class="form-group">
                        <label> Nombre Completo *</label>
                        <input type="text" id="nombre" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="form-group">
                        <label> Email *</label>
                        <input type="email" id="email" required placeholder="juan@email.com">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label> Teléfono</label>
                        <input type="tel" id="telefono" placeholder="1234567890">
                    </div>
                    <div class="form-group">
                        <label> Especialidad *</label>
                        <select id="especialidad" required>
                            <option value="">Seleccionar especialidad</option>
                            <option value="Yoga">Yoga</option>
                            <option value="CrossFit">CrossFit</option>
                            <option value="Musculación">Musculación</option>
                            <option value="Pilates">Pilates</option>
                            <option value="Spinning">Spinning</option>
                            <option value="Zumba">Zumba</option>
                        </select>
                    </div>
                </div>

                <!-- Horarios -->
                <div class="form-group">
                    <label> Horarios de Trabajo</label>
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <select id="diaSemana">
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                        </select>
                        <input type="time" id="horaInicio" placeholder="Hora inicio">
                        <input type="time" id="horaFin" placeholder="Hora fin">
                        <button type="button" class="btn btn-primary btn-small" onclick="agregarHorario()">+ Agregar</button>
                    </div>
                    <div id="horariosList" class="horarios-container"></div>
                </div>

                <!-- Clientes -->
                <div class="form-group">
                    <label> Clientes que Atiende</label>
                    <div id="clientesList" class="clientes-list"></div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary"> Guardar Instructor</button>
                    <button type="button" class="btn btn-warning" onclick="cancelarEdicion()"> Cancelar</button>
                </div>
            </form>
        </div>

        <!-- Tabla de Instructores -->
        <h2> Lista de Instructores</h2>
        <div class="table-container">
            <table id="instructoresTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Especialidad</th>
                        <th>Horarios</th>
                        <th>Clientes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="instructoresBody"></tbody>
            </table>
        </div>
    </div>

    <script>
        // Base de datos simulada con clientes disponibles
        let clientesDisponibles = [
            { id: 1, nombre: "María González", email: "maria@email.com" },
            { id: 2, nombre: "Carlos López", email: "carlos@email.com" },
            { id: 3, nombre: "Ana Martínez", email: "ana@email.com" },
            { id: 4, nombre: "Luis Rodríguez", email: "luis@email.com" },
            { id: 5, nombre: "Elena Sánchez", email: "elena@email.com" }
        ];

        let instructores = [];
        let horariosTemp = [];
        let clientesSeleccionadosTemp = [];

        // Cargar datos iniciales
        function cargarDatosIniciales() {
            const stored = localStorage.getItem('instructores_gym');
            if (stored) {
                instructores = JSON.parse(stored);
            } else {
                // Datos de ejemplo
                instructores = [
                    {
                        id: Date.now(),
                        nombre: "Laura Fernández",
                        email: "laura@gym.com",
                        telefono: "555-1234",
                        especialidad: "Yoga",
                        horarios: [
                            { dia: "Lunes", inicio: "09:00", fin: "12:00" },
                            { dia: "Miércoles", inicio: "09:00", fin: "12:00" }
                        ],
                        clientes: [1, 3]
                    }
                ];
                guardarEnLocalStorage();
            }
            actualizarTabla();
            actualizarEstadisticas();
        }

        function guardarEnLocalStorage() {
            localStorage.setItem('instructores_gym', JSON.stringify(instructores));
        }

        function actualizarTabla() {
            const tbody = document.getElementById('instructoresBody');
            tbody.innerHTML = '';

            instructores.forEach(instructor => {
                const row = tbody.insertRow();
                
                // Nombre
                row.insertCell(0).textContent = instructor.nombre;
                
                // Email
                row.insertCell(1).textContent = instructor.email;
                
                // Especialidad
                row.insertCell(2).textContent = instructor.especialidad;
                
                // Horarios
                const horariosCell = row.insertCell(3);
                const horariosHtml = instructor.horarios.map(h => 
                    `<span style="display: inline-block; background: #e9ecef; padding: 3px 8px; margin: 2px; border-radius: 12px; font-size: 12px;">
                        ${h.dia} ${h.inicio}-${h.fin}
                    </span>`
                ).join('');
                horariosCell.innerHTML = horariosHtml || 'No asignados';
                
                // Clientes
                const clientesCell = row.insertCell(4);
                const clientesNombres = instructor.clientes.map(id => {
                    const cliente = clientesDisponibles.find(c => c.id === id);
                    return cliente ? cliente.nombre : '';
                }).filter(n => n);
                clientesCell.innerHTML = clientesNombres.join(', ') || 'Sin clientes';
                
                // Acciones
                const accionesCell = row.insertCell(5);
                accionesCell.className = 'action-buttons';
                accionesCell.innerHTML = `
                    <button class="btn btn-primary btn-small" onclick="editarInstructor(${instructor.id})">✏️ Editar</button>
                    <button class="btn btn-danger btn-small" onclick="eliminarInstructor(${instructor.id})">🗑️ Eliminar</button>
                `;
            });
        }

        function actualizarEstadisticas() {
            document.getElementById('totalInstructores').textContent = instructores.length;
            
            const totalHorarios = instructores.reduce((sum, inst) => sum + inst.horarios.length, 0);
            document.getElementById('totalHorarios').textContent = totalHorarios;
            
            const totalClientes = instructores.reduce((sum, inst) => sum + inst.clientes.length, 0);
            document.getElementById('totalClientesAsignados').textContent = totalClientes;
        }

        function agregarHorario() {
            const dia = document.getElementById('diaSemana').value;
            const inicio = document.getElementById('horaInicio').value;
            const fin = document.getElementById('horaFin').value;
            
            if (!inicio || !fin) {
                alert('Por favor selecciona hora de inicio y fin');
                return;
            }
            
            horariosTemp.push({ dia, inicio, fin });
            actualizarListaHorarios();
            
            // Limpiar campos
            document.getElementById('horaInicio').value = '';
            document.getElementById('horaFin').value = '';
        }

        function actualizarListaHorarios() {
            const container = document.getElementById('horariosList');
            container.innerHTML = horariosTemp.map((h, index) => `
                <div class="horario-item">
                    ${h.dia} ${h.inicio}-${h.fin}
                    <span class="remove-horario" onclick="eliminarHorario(${index})">✖</span>
                </div>
            `).join('');
        }

        function eliminarHorario(index) {
            horariosTemp.splice(index, 1);
            actualizarListaHorarios();
        }

        function cargarClientesCheckbox() {
            const container = document.getElementById('clientesList');
            container.innerHTML = clientesDisponibles.map(cliente => `
                <div class="cliente-checkbox">
                    <input type="checkbox" value="${cliente.id}" id="cliente_${cliente.id}" 
                        ${clientesSeleccionadosTemp.includes(cliente.id) ? 'checked' : ''}>
                    <label for="cliente_${cliente.id}">${cliente.nombre} (${cliente.email})</label>
                </div>
            `).join('');
        }

        function obtenerClientesSeleccionados() {
            const checkboxes = document.querySelectorAll('#clientesList input[type="checkbox"]');
            return Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));
        }

        document.getElementById('instructorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('instructorId').value;
            const nombre = document.getElementById('nombre').value;
            const email = document.getElementById('email').value;
            const telefono = document.getElementById('telefono').value;
            const especialidad = document.getElementById('especialidad').value;
            
            if (!nombre || !email || !especialidad) {
                alert('Por favor completa los campos obligatorios');
                return;
            }
            
            const clientesSeleccionados = obtenerClientesSeleccionados();
            
            const instructorData = {
                nombre,
                email,
                telefono,
                especialidad,
                horarios: horariosTemp,
                clientes: clientesSeleccionados
            };
            
            if (id) {
                // Actualizar
                const index = instructores.findIndex(i => i.id == id);
                if (index !== -1) {
                    instructorData.id = parseInt(id);
                    instructores[index] = instructorData;
                }
            } else {
                // Crear nuevo
                instructorData.id = Date.now();
                instructores.push(instructorData);
            }
            
            guardarEnLocalStorage();
            actualizarTabla();
            actualizarEstadisticas();
            cancelarEdicion();
            alert('Instructor guardado exitosamente');
        });
        
        function editarInstructor(id) {
            const instructor = instructores.find(i => i.id === id);
            if (!instructor) return;
            
            document.getElementById('instructorId').value = instructor.id;
            document.getElementById('nombre').value = instructor.nombre;
            document.getElementById('email').value = instructor.email;
            document.getElementById('telefono').value = instructor.telefono || '';
            document.getElementById('especialidad').value = instructor.especialidad;
            
            horariosTemp = [...instructor.horarios];
            actualizarListaHorarios();
            
            clientesSeleccionadosTemp = [...instructor.clientes];
            cargarClientesCheckbox();
            
            document.getElementById('formTitle').textContent = '✏️ Editar Instructor';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function eliminarInstructor(id) {
            if (confirm('¿Estás seguro de eliminar este instructor?')) {
                instructores = instructores.filter(i => i.id !== id);
                guardarEnLocalStorage();
                actualizarTabla();
                actualizarEstadisticas();
                alert('Instructor eliminado');
            }
        }
        
        function cancelarEdicion() {
            document.getElementById('instructorForm').reset();
            document.getElementById('instructorId').value = '';
            horariosTemp = [];
            clientesSeleccionadosTemp = [];
            actualizarListaHorarios();
            cargarClientesCheckbox();
            document.getElementById('formTitle').textContent = 'Registrar Nuevo Instructor';
        }
        
        // Inicializar
        cargarDatosIniciales();
        cargarClientesCheckbox();
    </script>
</body>
</html>
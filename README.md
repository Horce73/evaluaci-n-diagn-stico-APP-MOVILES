# Sistema de Evaluaciones Diagnóstico

Sistema web de evaluaciones/exámenes desarrollado con Laravel y Docker. Permite a estudiantes realizar exámenes con preguntas aleatorias, ver sus resultados y mantener un historial de evaluaciones.

## Características

- **3 exámenes disponibles**: Matemáticas, Ciencias Naturales e Historia Universal
- **Banco de 25 preguntas por materia** — se sortean 5 aleatorias por intento
- **8 estudiantes pre-registrados** con códigos de acceso únicos
- **Temporizador** con auto-envío al terminar el tiempo
- **Protección contra abandono** — advertencia al intentar salir del examen
- **Verificación de código** para ver resultados de forma privada
- **Dashboard** con historial y estadísticas generales

---

## Requisitos

- Docker y Docker Compose instalados
- Git

---

## Instalación y Ejecución

### 1. Clonar el repositorio

```bash
git clone https://github.com/Horce73/evaluaci-n-diagn-stico-APP-MOVILES.git
cd evaluaci-n-diagn-stico-APP-MOVILES
```

### 2. Levantar los contenedores

```bash
docker compose up -d
```

Esto construirá la imagen de Docker e iniciará el contenedor Laravel en el puerto **8000**.

### 3. Ejecutar migraciones y seeders

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Esto creará todas las tablas y cargará los datos de prueba (estudiantes, exámenes y preguntas).

Al ejecutar el seeder, verás en consola los **códigos de acceso** de cada estudiante:

```
┌───────────────────────────────────────────────────┐
│  CÓDIGOS DE ACCESO DE ESTUDIANTES                 │
├───────────────────────────────────────────────────┤
│  Juan García López:           JG2401              │
│  María Hernández Pérez:       MH2402              │
│  Carlos Martínez Ruiz:        CM2403              │
│  Ana López Torres:            AL2404              │
│  Pedro Sánchez Gómez:         PS2405              │
│  Lucía Ramírez Vega:          LR2406              │
│  Miguel Flores Castillo:      MF2407              │
│  Sofía Moreno Díaz:           SM2408              │
└───────────────────────────────────────────────────┘
```

### 4. Acceder a la aplicación

Abre tu navegador en: **http://localhost:8000**

---

## Guía de Uso

### Panel Principal (Dashboard)

Al ingresar verás:
- **Estadísticas generales**: total de exámenes, exámenes realizados, estudiantes y promedio general
- **Historial de exámenes**: lista de todos los exámenes completados con calificaciones

### Sidebar de Navegación

- **Inicio**: Dashboard con estadísticas e historial
- **Exámenes Disponibles**: Lista de exámenes que se pueden realizar
- **Estudiantes**: Lista de estudiantes registrados con sus promedios

### Realizar un Examen

1. Ve a **Exámenes Disponibles** en el sidebar
2. Haz clic en **Iniciar** en el examen que deseas presentar
3. Selecciona tu nombre de la lista de estudiantes
4. Ingresa tu **código de acceso** (6 caracteres, ej: `JG2401`)
5. Haz clic en **Iniciar Examen**

### Durante el Examen

- Verás **5 preguntas aleatorias** del banco de 25 preguntas
- El **temporizador** en la esquina superior derecha muestra el tiempo restante
- Si intentas salir o cerrar la página, recibirás una **advertencia**
- Al terminar el tiempo, el examen se **envía automáticamente**

### Ver Resultados

1. Después de completar el examen, verás tu calificación inmediatamente
2. Para ver resultados desde el historial (Dashboard):
   - Haz clic en **Ver Resultado**
   - Ingresa tu **código de acceso** para verificar tu identidad
   - Verás el detalle de cada pregunta con tu respuesta y la correcta

---

## Estructura de la Base de Datos

| Tabla | Descripción |
|-------|-------------|
| `estudiantes` | Datos de estudiantes (nombre, email, matrícula, código_acceso) |
| `examenes` | Información de exámenes (título, descripción, duración, estado) |
| `preguntas` | Banco de preguntas (texto, tipo, opciones, respuesta_correcta) |
| `examen_pregunta` | Relación muchos-a-muchos entre exámenes y preguntas |
| `examen_estudiante` | Intentos de examen (respuestas, calificación, preguntas_ids) |

---

## Comandos Útiles

```bash
# Ver logs del contenedor
docker compose logs -f app

# Acceder al contenedor
docker compose exec app bash

# Limpiar y reiniciar la base de datos
docker compose exec app php artisan migrate:fresh --seed

# Detener los contenedores
docker compose down

# Reconstruir la imagen
docker compose up -d --build
```

---

## Tecnologías Utilizadas

- **Laravel 11** — Framework PHP
- **SQLite** — Base de datos
- **Tailwind CSS** (CDN) — Estilos
- **Docker** — Contenedorización
- **Blade** — Motor de plantillas

---

## Autor

Proyecto desarrollado para la materia de Aplicaciones Móviles.

---

## Licencia

Este proyecto está bajo la licencia MIT.

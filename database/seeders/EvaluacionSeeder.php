<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\Examen;
use App\Models\Pregunta;

class EvaluacionSeeder extends Seeder
{
    public function run(): void
    {
        // ── Estudiantes (con código de acceso único) ─────────────────────────────
        $estudiantes = [
            ['nombre' => 'Juan',   'apellido' => 'García López',    'email' => 'juan.garcia@estudiante.edu',    'matricula' => '2024001', 'codigo_acceso' => 'JG2401'],
            ['nombre' => 'María',  'apellido' => 'Hernández Pérez', 'email' => 'maria.hernandez@estudiante.edu','matricula' => '2024002', 'codigo_acceso' => 'MH2402'],
            ['nombre' => 'Carlos', 'apellido' => 'Martínez Ruiz',   'email' => 'carlos.martinez@estudiante.edu','matricula' => '2024003', 'codigo_acceso' => 'CM2403'],
            ['nombre' => 'Ana',    'apellido' => 'López Torres',    'email' => 'ana.lopez@estudiante.edu',      'matricula' => '2024004', 'codigo_acceso' => 'AL2404'],
            ['nombre' => 'Pedro',  'apellido' => 'Sánchez Gómez',   'email' => 'pedro.sanchez@estudiante.edu',  'matricula' => '2024005', 'codigo_acceso' => 'PS2405'],
            ['nombre' => 'Lucía',  'apellido' => 'Ramírez Vega',    'email' => 'lucia.ramirez@estudiante.edu',  'matricula' => '2024006', 'codigo_acceso' => 'LR2406'],
            ['nombre' => 'Miguel', 'apellido' => 'Flores Castillo', 'email' => 'miguel.flores@estudiante.edu',  'matricula' => '2024007', 'codigo_acceso' => 'MF2407'],
            ['nombre' => 'Sofía',  'apellido' => 'Moreno Díaz',     'email' => 'sofia.moreno@estudiante.edu',   'matricula' => '2024008', 'codigo_acceso' => 'SM2408'],
        ];

        foreach ($estudiantes as $e) {
            Estudiante::create($e);
        }

        // Mostrar códigos de acceso en consola
        $this->command->newLine();
        $this->command->info('┌───────────────────────────────────────────────────┐');
        $this->command->info('│  CÓDIGOS DE ACCESO DE ESTUDIANTES                 │');
        $this->command->info('├───────────────────────────────────────────────────┤');
        foreach ($estudiantes as $e) {
            $line = sprintf("│  %-30s %s  │", "{$e['nombre']} {$e['apellido']}:", $e['codigo_acceso']);
            $this->command->info($line);
        }
        $this->command->info('└───────────────────────────────────────────────────┘');

        // ── Banco de preguntas: Matemáticas (25) ────────────────────────────────
        $preguntasMatematicas = [
            ['texto'=>'¿Cuánto es 15 + 27?','tipo'=>'opcion_multiple','opciones'=>['a'=>'40','b'=>'42','c'=>'44','d'=>'52'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuánto es 8 × 7?','tipo'=>'opcion_multiple','opciones'=>['a'=>'54','b'=>'56','c'=>'58','d'=>'64'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'La raíz cuadrada de 144 es 12.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál es el valor de π aproximado a dos decimales?','tipo'=>'opcion_multiple','opciones'=>['a'=>'3.12','b'=>'3.14','c'=>'3.16','d'=>'3.18'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'100 ÷ 4 = 25.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuánto es 9²?','tipo'=>'opcion_multiple','opciones'=>['a'=>'72','b'=>'81','c'=>'91','d'=>'99'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuál es el resultado de 5! (factorial de 5)?','tipo'=>'opcion_multiple','opciones'=>['a'=>'60','b'=>'100','c'=>'120','d'=>'150'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'El número primo mayor menor que 10 es 7.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuánto es 2⁸?','tipo'=>'opcion_multiple','opciones'=>['a'=>'128','b'=>'256','c'=>'512','d'=>'64'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuántos lados tiene un hexágono?','tipo'=>'opcion_multiple','opciones'=>['a'=>'5','b'=>'6','c'=>'7','d'=>'8'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'El número 1 es un número primo.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Cuánto es √(25 + 144)?','tipo'=>'opcion_multiple','opciones'=>['a'=>'11','b'=>'13','c'=>'15','d'=>'17'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuánto es 3/4 + 1/2?','tipo'=>'opcion_multiple','opciones'=>['a'=>'4/6','b'=>'1','c'=>'5/4','d'=>'4/4'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'Un ángulo recto mide 90°.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál es el conjunto correcto de factores de 12?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1,2,3,4,6','b'=>'1,2,3,4,6,12','c'=>'2,3,4,6','d'=>'1,2,6,12'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuál es el mínimo común múltiplo de 4 y 6?','tipo'=>'opcion_multiple','opciones'=>['a'=>'12','b'=>'18','c'=>'24','d'=>'6'],'respuesta_correcta'=>'a','puntaje'=>1],
            ['texto'=>'¿Cuánto es el 15% de 200?','tipo'=>'opcion_multiple','opciones'=>['a'=>'20','b'=>'25','c'=>'30','d'=>'35'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'La suma de los ángulos internos de un triángulo es 180°.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuánto es -5 × (-3)?','tipo'=>'opcion_multiple','opciones'=>['a'=>'-15','b'=>'-8','c'=>'8','d'=>'15'],'respuesta_correcta'=>'d','puntaje'=>1],
            ['texto'=>'¿Cuál es el área de un cuadrado con lado 7?','tipo'=>'opcion_multiple','opciones'=>['a'=>'14','b'=>'28','c'=>'49','d'=>'56'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Cuánto es log₁₀(1000)?','tipo'=>'opcion_multiple','opciones'=>['a'=>'2','b'=>'3','c'=>'4','d'=>'10'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'El cuadrado de un número negativo siempre es positivo.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuánto mide la hipotenusa de un triángulo rectángulo con catetos 3 y 4?','tipo'=>'opcion_multiple','opciones'=>['a'=>'5','b'=>'6','c'=>'7','d'=>'8'],'respuesta_correcta'=>'a','puntaje'=>1],
            ['texto'=>'¿Cuánto es 1000 ÷ 0.1?','tipo'=>'opcion_multiple','opciones'=>['a'=>'100','b'=>'1000','c'=>'10000','d'=>'1'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'El número 0 es par.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
        ];

        // ── Banco de preguntas: Ciencias Naturales (25) ──────────────────────────
        $preguntasCiencias = [
            ['texto'=>'¿Cuál es el símbolo químico del agua?','tipo'=>'opcion_multiple','opciones'=>['a'=>'H2O','b'=>'CO2','c'=>'O2','d'=>'NaCl'],'respuesta_correcta'=>'a','puntaje'=>1],
            ['texto'=>'¿Cuántos planetas tiene nuestro sistema solar?','tipo'=>'opcion_multiple','opciones'=>['a'=>'7','b'=>'8','c'=>'9','d'=>'10'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'El sol es una estrella.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál es el órgano más grande del cuerpo humano?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Corazón','b'=>'Hígado','c'=>'Piel','d'=>'Pulmones'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'La fotosíntesis produce oxígeno.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuántos cromosomas tiene una célula humana normal?','tipo'=>'opcion_multiple','opciones'=>['a'=>'23','b'=>'46','c'=>'48','d'=>'92'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuál es el gas más abundante en la atmósfera terrestre?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Oxígeno','b'=>'Dióxido de carbono','c'=>'Nitrógeno','d'=>'Argón'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'El ADN se encuentra en el núcleo de la célula.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿A cuántos grados Celsius hierve el agua a nivel del mar?','tipo'=>'opcion_multiple','opciones'=>['a'=>'90°C','b'=>'95°C','c'=>'100°C','d'=>'110°C'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Cuántas cámaras tiene el corazón humano?','tipo'=>'opcion_multiple','opciones'=>['a'=>'2','b'=>'3','c'=>'4','d'=>'6'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'La luna tiene atmósfera.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Cuál es el número atómico del carbono?','tipo'=>'opcion_multiple','opciones'=>['a'=>'4','b'=>'6','c'=>'8','d'=>'12'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Cuál es la unidad básica de la vida?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Tejido','b'=>'Órgano','c'=>'Célula','d'=>'Átomo'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'Los virus son seres vivos porque tienen células.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Cuál es el planeta más grande del sistema solar?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Saturno','b'=>'Neptuno','c'=>'Júpiter','d'=>'Urano'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Cuántos huesos tiene el cuerpo humano adulto?','tipo'=>'opcion_multiple','opciones'=>['a'=>'186','b'=>'206','c'=>'226','d'=>'246'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'El oxígeno es producido por las plantas durante la fotosíntesis.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál es la fórmula del dióxido de carbono?','tipo'=>'opcion_multiple','opciones'=>['a'=>'CO','b'=>'CO2','c'=>'C2O','d'=>'C2O2'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Qué organelo celular produce energía?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Núcleo','b'=>'Ribosoma','c'=>'Mitocondria','d'=>'Vacuola'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'La gravedad en la luna es mayor que en la Tierra.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Cuál es la velocidad de la luz en el vacío (aprox.)?','tipo'=>'opcion_multiple','opciones'=>['a'=>'150,000 km/s','b'=>'200,000 km/s','c'=>'300,000 km/s','d'=>'400,000 km/s'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'El sistema nervioso central está compuesto por el cerebro y la médula espinal.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál es el elemento más abundante en la corteza terrestre?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Hierro','b'=>'Silicio','c'=>'Oxígeno','d'=>'Aluminio'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Cuántas capas tiene la Tierra?','tipo'=>'opcion_multiple','opciones'=>['a'=>'2','b'=>'3','c'=>'4','d'=>'5'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'Los mamíferos son animales de sangre fría.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
        ];

        // ── Banco de preguntas: Historia Universal (25) ──────────────────────────
        $preguntasHistoria = [
            ['texto'=>'¿En qué año llegó Cristóbal Colón a América?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1490','b'=>'1492','c'=>'1494','d'=>'1500'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Quién escribió "Don Quijote de la Mancha"?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Lope de Vega','b'=>'Calderón de la Barca','c'=>'Miguel de Cervantes','d'=>'Francisco de Quevedo'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'La Revolución Francesa comenzó en 1789.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿En qué año terminó la Segunda Guerra Mundial?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1943','b'=>'1944','c'=>'1945','d'=>'1946'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Quién fue el primer presidente de los Estados Unidos?','tipo'=>'opcion_multiple','opciones'=>['a'=>'John Adams','b'=>'Benjamin Franklin','c'=>'Thomas Jefferson','d'=>'George Washington'],'respuesta_correcta'=>'d','puntaje'=>1],
            ['texto'=>'El Imperio Romano cayó en el año 476 d.C.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿En qué continente se desarrolló la civilización egipcia?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Asia','b'=>'Europa','c'=>'África','d'=>'América'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿Quién pintó la Mona Lisa?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Miguel Ángel','b'=>'Rafael','c'=>'Botticelli','d'=>'Leonardo da Vinci'],'respuesta_correcta'=>'d','puntaje'=>1],
            ['texto'=>'La Revolución Industrial comenzó en Inglaterra.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿En qué año comenzó la Primera Guerra Mundial?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1912','b'=>'1914','c'=>'1916','d'=>'1918'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿Quién fue Napoleón Bonaparte?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Rey de España','b'=>'Emperador de Francia','c'=>'Czar de Rusia','d'=>'Kaiser de Alemania'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'Las pirámides de Giza fueron construidas por los mayas.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿En qué año llegó el hombre a la Luna?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1965','b'=>'1967','c'=>'1969','d'=>'1971'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿En qué ciudad se firmó la Declaración de Independencia de EE.UU.?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Boston','b'=>'Nueva York','c'=>'Washington D.C.','d'=>'Filadelfia'],'respuesta_correcta'=>'d','puntaje'=>1],
            ['texto'=>'La Guerra Fría fue un conflicto armado entre EE.UU. y la URSS.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Quién fue el líder de la Revolución Cubana?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Che Guevara','b'=>'Fidel Castro','c'=>'Raúl Castro','d'=>'Fulgencio Batista'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'¿En qué año cayó el Muro de Berlín?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1987','b'=>'1988','c'=>'1989','d'=>'1990'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'Nelson Mandela fue presidente de Sudáfrica.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Cuál fue la primera civilización de Mesopotamia?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Babilonia','b'=>'Asiria','c'=>'Sumeria','d'=>'Persia'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿En qué país nació Adolf Hitler?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Alemania','b'=>'Austria','c'=>'Polonia','d'=>'Suiza'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'Cristóbal Colón era de nacionalidad española.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'falso','puntaje'=>1],
            ['texto'=>'¿Qué civilización construyó Machu Picchu?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Azteca','b'=>'Maya','c'=>'Inca','d'=>'Olmeca'],'respuesta_correcta'=>'c','puntaje'=>1],
            ['texto'=>'¿En qué año se fundó la ONU?','tipo'=>'opcion_multiple','opciones'=>['a'=>'1943','b'=>'1945','c'=>'1947','d'=>'1950'],'respuesta_correcta'=>'b','puntaje'=>1],
            ['texto'=>'La Conquista de México fue liderada por Hernán Cortés.','tipo'=>'verdadero_falso','opciones'=>null,'respuesta_correcta'=>'verdadero','puntaje'=>1],
            ['texto'=>'¿Quién fue el primer cosmonauta en orbitar la Tierra?','tipo'=>'opcion_multiple','opciones'=>['a'=>'Neil Armstrong','b'=>'Buzz Aldrin','c'=>'Yuri Gagarin','d'=>'Alan Shepard'],'respuesta_correcta'=>'c','puntaje'=>1],
        ];

        // ── Crear exámenes ───────────────────────────────────────────────────────
        $examenMate = Examen::create([
            'titulo'           => 'Examen de Matemáticas',
            'descripcion'      => 'Aritmética, geometría y álgebra básica. Banco de 25 preguntas — se sortean 5 al iniciar.',
            'duracion_minutos' => 30,
            'estado'           => 'activo',
        ]);

        $examenCiencias = Examen::create([
            'titulo'           => 'Examen de Ciencias Naturales',
            'descripcion'      => 'Biología, química y física. Banco de 25 preguntas — se sortean 5 al iniciar.',
            'duracion_minutos' => 45,
            'estado'           => 'activo',
        ]);

        $examenHistoria = Examen::create([
            'titulo'           => 'Examen de Historia Universal',
            'descripcion'      => 'Conocimientos históricos generales. Banco de 25 preguntas — se sortean 5 al iniciar.',
            'duracion_minutos' => 30,
            'estado'           => 'activo',
        ]);

        // ── Asociar preguntas a exámenes ─────────────────────────────────────────
        $this->asociarPreguntas($examenMate,     $preguntasMatematicas);
        $this->asociarPreguntas($examenCiencias, $preguntasCiencias);
        $this->asociarPreguntas($examenHistoria, $preguntasHistoria);

        $this->command->info('Datos de evaluación creados exitosamente.');
        $this->command->info('  - 8 estudiantes');
        $this->command->info('  - 3 exámenes (cada uno con 25 preguntas; se sortean 5 al iniciar)');
    }

    private function asociarPreguntas(Examen $examen, array $preguntasData): void
    {
        foreach ($preguntasData as $orden => $datos) {
            $pregunta = Pregunta::create($datos);
            $examen->preguntas()->attach($pregunta->id, ['orden' => $orden + 1]);
        }
    }
}

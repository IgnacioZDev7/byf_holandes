<?php

namespace Database\Seeders;

use App\Models\CatProcedimiento;
use Illuminate\Database\Seeder;

class ProcedimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procedimientos = [
            ['codigo' => 'T17576002', 'nombre' => 'Consulta Int. Cardiología'],
            ['codigo' => 'T17576005', 'nombre' => 'Consulta Int. Cirugía Maxilo Facial'],
            ['codigo' => 'T17576009', 'nombre' => 'Consulta Int. Gastroenterología'],
            ['codigo' => 'T17576012', 'nombre' => 'Consulta Int. Ginecología y Obstetricia'],
            ['codigo' => 'T17576017', 'nombre' => 'Consulta Int. Medicina Interna'],
            ['codigo' => 'T17576020', 'nombre' => 'Consulta Int. Neumología'],
            ['codigo' => 'T17576034', 'nombre' => 'Consulta Int. Traumatología y Ortopedia'],
            ['codigo' => 'T17576004', 'nombre' => 'Consulta Int. Cirugía General'],
            ['codigo' => 'T17576035', 'nombre' => 'Consulta Int. Urología'],
            ['codigo' => 'T17576018', 'nombre' => 'Consulta Int. Nefrología'],
            ['codigo' => 'T17576029', 'nombre' => 'Consulta Int. Pediatría'],
            ['codigo' => 'T17576003', 'nombre' => 'Consulta Int. Cirugía Cardiovascular y Angiología'],
            ['codigo' => 'T17576027', 'nombre' => 'Consulta Int. Otras especialidades'],
            ['codigo' => 'T17576036', 'nombre' => 'Consulta Int. Urgencias y Emergencias'],
            ['codigo' => 'T17576001', 'nombre' => 'Consulta Seg. Enfermedades No Transmisibles Crónicas'],
            ['codigo' => 'T17638014', 'nombre' => 'Inyectables en Consultorio Externo'],
            ['codigo' => 'T17638020', 'nombre' => 'Sutura en Consultorio Externo'],
            ['codigo' => 'T17638019', 'nombre' => 'Retiro de Puntos en Consultorio Externo'],
            ['codigo' => 'T17638007', 'nombre' => 'Colocación y Mantenimiento de Catéter Sub. C.E.'],
            ['codigo' => 'T17638003', 'nombre' => 'Cateterismo Venoso Periférico en Consultorio'],
            ['codigo' => 'T17638004', 'nombre' => 'Cateterismo Vesical en Consultorio Externo'],
            ['codigo' => 'T17638009', 'nombre' => 'Curación en Consultorio Externo'],
            ['codigo' => 'T17638008', 'nombre' => 'Curación de Escaras en Consultorio Externo'],
            ['codigo' => 'T17638017', 'nombre' => 'Onicectomía (Escisión Uña Encarnada) en Consultorio Externo'],
            // Segunda parte
            ['codigo' => 'T17577010', 'nombre' => 'Control Int. de Nutrición y Dietética'],
            ['codigo' => 'T17576041', 'nombre' => 'Control Prenatal Alto Riesgo Obstétrico Atendido por Médico'],
            ['codigo' => 'T17639001', 'nombre' => 'Aspirado faríngeo para diag. TB en consultorio externo'],
            ['codigo' => 'T17639012', 'nombre' => 'Hisopado Faríngeo en Consultorio Externo'],
            ['codigo' => 'T17639013', 'nombre' => 'Hisopado Nasal en Consultorio Externo'],
            ['codigo' => 'T17639016', 'nombre' => 'Nebulización en Consultorio Externo'],
            ['codigo' => 'T17639018', 'nombre' => 'Procedos en Consultorio Externo'],
            ['codigo' => 'T31674003', 'nombre' => 'Reducción Incruenta de Fracturas Menores'],
            ['codigo' => 'T17639011', 'nombre' => 'Dilatación Uretral'],
            ['codigo' => 'T31699001', 'nombre' => 'Tb. Otoscopia Completa Luxación Congénita de Cadera, (uni o bilateral)'],
            ['codigo' => 'T31668001', 'nombre' => 'Regularización de Muñón de Amputación'],
            ['codigo' => 'T31686004', 'nombre' => 'Tratamiento de Esguinces'],
            ['codigo' => 'T08639004', 'nombre' => 'Anestesia Local'],
            ['codigo' => 'T29544005', 'nombre' => 'Obtención de Piel y Úlcera Venosa'],
            ['codigo' => 'T17639010', 'nombre' => 'Debridamiento de Lesiones Infecciosas'],
            ['codigo' => 'T15653024', 'nombre' => 'Infiltración Articular - Partes Blandas'],
            ['codigo' => 'T02563004', 'nombre' => 'Inmovilización Fracturas Expuestas o Cerradas'],
            ['codigo' => 'T17639023', 'nombre' => 'Retiro de Yeso en Consultorio Externo'],
            ['codigo' => 'T17639022', 'nombre' => 'Cambio de Yeso en Consultorio Externo'],
            ['codigo' => 'T28547004', 'nombre' => 'Drenaje de Absceso de Piso de la Boca'],
            ['codigo' => 'D20547006', 'nombre' => 'Colocoscopía y Biopsia'],
            ['codigo' => 'P07504004', 'nombre' => 'Inserción de Implante Subdérmico Anticonceptivo'],
            ['codigo' => 'P07505004', 'nombre' => 'Prevención de Anemia en Embarazada'],
            ['codigo' => 'P07636006', 'nombre' => 'Prevención de Anemia en Puerperas'],
            // Tercera parte
            ['codigo' => 'P07504012', 'nombre' => 'Retiro de DIU'],
            ['codigo' => 'P07504013', 'nombre' => 'Retiro de Implante Subdérmico Anticonceptivo'],
            ['codigo' => 'P07504003', 'nombre' => 'Inserción de DIU'],
            ['codigo' => 'T09661001', 'nombre' => 'Control de Marcapaso'],
            ['codigo' => 'T16664006', 'nombre' => 'Extracción de Lesión Benigna Sub. Lipoma'],
            ['codigo' => 'T02662001', 'nombre' => 'Cardioversion Farmacológica de Emergencia'],
            ['codigo' => 'T02662008', 'nombre' => 'Toracocentesis Diagnóstica y Terapéutica Emergencia'],
            ['codigo' => 'T02663010', 'nombre' => 'Colocación de Catéter Venoso Central en Urgencias'],
            ['codigo' => 'T02663001', 'nombre' => 'Cateterismo Venoso Periférico en Urgencias'],
            ['codigo' => 'T02663002', 'nombre' => 'Cateterismo Vesical en Urgencias'],
            ['codigo' => 'T11690001', 'nombre' => 'Curación Quemadura de 5 a 10% Superficie Corporal'],
            ['codigo' => 'T11900003', 'nombre' => 'Curación Quemadura menor a 5% Superficie Corporal'],
            ['codigo' => 'T02662005', 'nombre' => 'Intubación Endotraqueal de Emergencia (nonneonatal)'],
            ['codigo' => 'T19603004', 'nombre' => 'Día Cama para Observación en Servicio de urgencia/emergencia'],
            ['codigo' => 'T02662002', 'nombre' => 'Desfibrilación Externa Automática de Emergencia'],
            ['codigo' => 'T02662003', 'nombre' => 'Extracción Cuerpo Extraño de Vía respiratoria mediante Laringoscopia de Emergencia'],
            ['codigo' => 'T02662006', 'nombre' => 'Lavado Gástrico de Intoxicaciones'],
            ['codigo' => 'T02663005', 'nombre' => 'Lavado Ocular en Urgencias'],
            ['codigo' => 'T02662007', 'nombre' => 'RCP de Emergencia'],
            ['codigo' => 'T12665024', 'nombre' => 'Ventilación Mecánica no Invasiva'],
            ['codigo' => 'T02662002', 'nombre' => 'Desfibrilación Externa Automática de Emergencia (posible duplicado)'],
            ['codigo' => 'T02663003', 'nombre' => 'Colocación de Sonda Nasogástrica en Urgencias'],
            ['codigo' => 'T02663006', 'nombre' => 'Sutura en urgencias'],
            ['codigo' => 'T30567002', 'nombre' => 'Frenicectomía'],
        ];

        foreach ($procedimientos as $procedimiento) {
            CatProcedimiento::firstOrCreate(
                ['codigo' => $procedimiento['codigo']],
                [
                    'nombre' => $procedimiento['nombre'],
                    'area' => 'Consulta Externa',
                    'activa' => true,
                ]
            );
        }
    }
}
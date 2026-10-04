<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterIcd10;

class MasterIcd10Seeder extends Seeder
{
    public function run()
    {
        // Hapus data lama agar tidak duplikat saat di-seed ulang
        MasterIcd10::truncate();
        
        $data = [
            ['A00', 'Cholera'],
            ['A01', 'Typhoid and paratyphoid fevers'],
            ['A01.0', 'Typhoid fever (Demam Tifoid)'],
            ['A03', 'Shigellosis (Disentri)'],
            ['A04.9', 'Bacterial intestinal infection, unspecified (Infeksi Bakteri Usus)'],
            ['A06.0', 'Acute amebic dysentery (Disentri Amuba Akut)'],
            ['A09', 'Diarrhoea and gastroenteritis of presumed infectious origin (Diare)'],
            ['A15', 'Respiratory tuberculosis, bacteriologically and histologically confirmed (TBC Paru)'],
            ['A16', 'Respiratory tuberculosis, not confirmed bacteriologically or histologically'],
            ['A30', 'Leprosy [Hansen disease] (Kusta)'],
            ['A90', 'Dengue fever [classical dengue] (Demam Dengue)'],
            ['A91', 'Dengue haemorrhagic fever (DBD)'],
            ['B01', 'Varicella [chickenpox] (Cacar Air)'],
            ['B02', 'Zoster [herpes zoster]'],
            ['B05', 'Measles (Campak)'],
            ['B15', 'Acute hepatitis A'],
            ['B18', 'Chronic viral hepatitis'],
            ['B20', 'Human immunodeficiency virus [HIV] disease (Penyakit HIV)'],
            ['B26', 'Mumps (Gondongan)'],
            ['B35', 'Dermatophytosis (Kadas/Kurap)'],
            ['B37', 'Candidiasis'],
            ['B86', 'Scabies (Kudis)'],
            ['E10', 'Type 1 diabetes mellitus (DM Tipe 1)'],
            ['E11', 'Type 2 diabetes mellitus (DM Tipe 2)'],
            ['E66', 'Obesity (Obesitas)'],
            ['E78.5', 'Hyperlipidaemia, unspecified (Kolesterol Tinggi)'],
            ['E87', 'Other disorders of fluid, electrolyte and acid-base balance'],
            ['F32', 'Depressive episode (Depresi)'],
            ['F41.9', 'Anxiety disorder, unspecified (Gangguan Kecemasan)'],
            ['G40', 'Epilepsy (Epilepsi / Ayan)'],
            ['G43', 'Migraine (Migrain)'],
            ['G44.2', 'Tension-type headache (Sakit Kepala Tegang)'],
            ['H00.0', 'Hordeolum and other deep inflammation of eyelid (Bintitan)'],
            ['H10', 'Conjunctivitis (Mata Merah)'],
            ['H52.1', 'Myopia (Mata Minus)'],
            ['H65', 'Nonsuppurative otitis media (Infeksi Telinga Tengah)'],
            ['I10', 'Essential (primary) hypertension (Hipertensi Primer)'],
            ['I11', 'Hypertensive heart disease (Penyakit Jantung Hipertensi)'],
            ['I20', 'Angina pectoris (Angina / Angin Duduk)'],
            ['I21', 'Acute myocardial infarction (Serangan Jantung Akut)'],
            ['I50', 'Heart failure (Gagal Jantung)'],
            ['I64', 'Stroke, not specified as haemorrhage or infarction (Stroke)'],
            ['J00', 'Acute nasopharyngitis [common cold] (Flu Biasa / Selesma)'],
            ['J01', 'Acute sinusitis (Sinusitis Akut)'],
            ['J02', 'Acute pharyngitis (Radang Tenggorokan Akut)'],
            ['J03', 'Acute tonsillitis (Radang Amandel Akut)'],
            ['J06.9', 'Acute upper respiratory infection, unspecified (ISPA)'],
            ['J11', 'Influenza, virus not identified (Influenza)'],
            ['J20', 'Acute bronchitis (Bronkitis Akut)'],
            ['J45', 'Asthma (Asma)'],
            ['K02', 'Dental caries (Gigi Berlubang)'],
            ['K04', 'Diseases of pulp and periapical tissues (Penyakit Pulpa Gigi)'],
            ['K21', 'Gastro-oesophageal reflux disease (GERD / Asam Lambung)'],
            ['K29.7', 'Gastritis, unspecified (Maag / Gastritis)'],
            ['K35', 'Acute appendicitis (Usus Buntu Akut)'],
            ['K52.9', 'Noninfective gastroenteritis and colitis, unspecified (Gastroenteritis Noninfeksi)'],
            ['K80', 'Cholelithiasis (Batu Empedu)'],
            ['L20', 'Atopic dermatitis (Eksim Atopik)'],
            ['L50', 'Urticaria (Biduran / Kaligata)'],
            ['L70', 'Acne (Jerawat)'],
            ['M06.9', 'Rheumatoid arthritis, unspecified (Rematik)'],
            ['M10', 'Gout (Asam Urat)'],
            ['M19.9', 'Arthrosis, unspecified (Pengapuran Sendi / Osteoarthritis)'],
            ['M54.2', 'Cervicalgia (Nyeri Leher)'],
            ['M54.5', 'Low back pain (Nyeri Punggung Bawah)'],
            ['M79.1', 'Myalgia (Nyeri Otot)'],
            ['N17', 'Acute kidney failure (Gagal Ginjal Akut)'],
            ['N18', 'Chronic kidney disease (Gagal Ginjal Kronik)'],
            ['N20', 'Calculus of kidney and ureter (Batu Ginjal / Saluran Kemih)'],
            ['N30', 'Cystitis (Infeksi Kandung Kemih)'],
            ['N39.0', 'Urinary tract infection, site not specified (ISK)'],
            ['O20.0', 'Threatened abortion (Ancaman Keguguran)'],
            ['O80', 'Single spontaneous delivery (Persalinan Normal)'],
            ['R10.4', 'Other and unspecified abdominal pain (Sakit Perut)'],
            ['R50.9', 'Fever, unspecified (Demam)'],
            ['R51', 'Headache (Sakit Kepala)'],
            ['Z00.0', 'General medical examination (Pemeriksaan Medis Umum / MCU)'],
            ['Z01.2', 'Dental examination (Pemeriksaan Gigi)'],
            ['Z11.5', 'Special screening examination for other viral diseases (Skrining Virus)'],
            ['Z30.0', 'General counselling and advice on contraception (Konsultasi KB)'],
            ['Z76.0', 'Issue of repeat prescription (Resep Ulang)'],
        ];

        foreach ($data as $item) {
            MasterIcd10::create([
                'kode_icd10' => $item[0],
                'nama_diagnosa' => $item[1],
            ]);
        }
    }
}

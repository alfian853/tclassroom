<?php

namespace App\Helpers;

use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapNilaiExcel implements FromCollection, WithHeadings
{

    private $data;
    private $header;


    public function __construct($agendaId){
        $listRekapNilai = DB::table('agenda')->selectRaw('us.idUser as nrp,us.name as nama,GROUP_CONCAT(
        IFNULL(ptg.nilai, 0) order by tg.created_at) as rekap_nilai')
            ->join('pertemuan as pt','pt.agenda_id','=','agenda.idAgenda')
            ->join('tugas as tg','tg.pertemuan_id','=','pt.id')
            ->join('pengumpulan_tugas as ptg','ptg.tugas_id','=','tg.id')
            ->join('users as us','us.idUser','=','ptg.mhs_id')
            ->where('agenda.idAgenda','=',$agendaId)
            ->groupBy('us.idUser')->get();

        $this->data = [];

        foreach ($listRekapNilai as $rekap){
            $tmp = [$rekap->nrp,$rekap->nama];
            $tmp = array_merge($tmp,preg_split('/\,/',$rekap->rekap_nilai));
            array_push($this->data,$tmp);
        }


        $this->header = preg_split('/\,/',
            DB::table('agenda')
            ->selectRaw('GROUP_CONCAT(CONCAT(tg.judul,\'/pertemuan-\',pt.no_pertemuan) 
            order by tg.created_at) as daftar_tugas')
            ->join('pertemuan as pt','pt.agenda_id','=','agenda.idAgenda')
            ->join('tugas as tg','tg.pertemuan_id','=','pt.id')
            ->join('pengumpulan_tugas as ptg','ptg.tugas_id','=','tg.id')
            ->join('users as us','us.idUser','=','ptg.mhs_id')
            ->where('agenda.idAgenda','=','IF184605I_19')
            ->groupBy('us.name')->limit(1)->first()->daftar_tugas
        );
        $this->header = array_merge(['nrp','nama'],$this->header);
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect($this->data);
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->header;
    }
}
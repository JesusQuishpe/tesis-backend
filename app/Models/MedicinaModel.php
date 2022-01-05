<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class MedicinaModel
{
    public function getClientes()
    {
        return DB::select('select C.id, 
        A.nombres as nombre,
         A.apellidos as apellido, 
         A.nacimiento as fecha_nac, 
         C.peso,B.areaaCita 
        from ingresar A inner join citas B on A.num=B.num
        inner join enfermeria C on C.id=B.id
        where B.fechaCita=CURDATE() order by B.horaCita asc', []);
    }
}

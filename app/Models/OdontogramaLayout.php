<?php

namespace App\Models;

class OdontogramaLayout
{
    //private bool $disabled;
    //private bool $enableEvents;
    //private bool $showPaleta;
    private $data;




    /**
     * Class constructor.
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    public function crearOdontograma()
    {
        $template="";
        $template.=$this->crearMovilidadRecesion('Recesion',0,16);
        $template.=$this->crearMovilidadRecesion('Movilidad',16,32);
        $template.=$this->crearSeccionDientes();
        $template.=$this->crearMovilidadRecesion('Recesion',32,48);
        $template.=$this->crearMovilidadRecesion('Movilidad',48,64);
        return $template;
    }
    public function crearSeccionDientes()
    {
        $gridItemstemplate = "";
        $start = 0;
        $end = 0;

        //Creamos la primera columna que es el titulo "Vestibular"
        $gridItemstemplate .= $this->crearGridText("Vestibular");

        //Primeros 8 vestibular
        $start = 18;
        $end = 11;
        $gridItemstemplate .= $this->crearDientes($start, $end, "vestibular", false);
        //Segundos 8 vestibulares
        $start = 21;
        $end = 28;
        $gridItemstemplate .= $this->crearDientes($start, $end, "vestibular", false);

        //Creamos la segunda columna que es el titulo "Lingual"
        $gridItemstemplate .= $this->crearGridText("Lingual");

        //Primeros 8 linguales
        $start = 55;
        $end = 51;
        $gridItemstemplate .=$this->crearDientes($start, $end, "lingual", false);

        //Segundos 8 linguales
        $start = 61;
        $end = 65;
        $gridItemstemplate .=$this->crearDientes($start, $end, "lingual", false);


        //Terceros 8 linguales
        $start = 85;
        $end = 81;
        $gridItemstemplate .= $this->crearDientes($start, $end, "lingual", true);

        //Cuartos 8 linguales
        $start = 71;
        $end = 75;
        $gridItemstemplate .=$this->crearDientes($start, $end, "lingual", true);

        //Creamos la primera columna que es el titulo "Vestibular"
        $gridItemstemplate .=$this->crearGridText("Vestibular");

        //Penultimos 8 vestibulares
        $start = 48;
        $end = 41;
        $gridItemstemplate .=$this->crearDientes($start, $end, "vestibular", true);

        //Ultimos 8 vestibulares
        $start = 31;
        $end = 38;
        $gridItemstemplate .=$this->crearDientes($start, $end, "vestibular", true);

        return $gridItemstemplate;
    }

    public function crearMovilidadRecesion($tipo,$start,$end)
    {
        $template="";
        $template.=$this->crearGridText($tipo);
        for ($i=$start; $i < $end; $i++) {
            $valor=""; 
            foreach ($this->data['recmovs'] as $recmov) {
                if($recmov->pos===$i){
                    $valor=$recmov->valor;
                    break;
                }
            }
            $template.="
                <div class='grid-item'>
                    <input type='text' maxlength='1' class='input-recmov' tipo={strtolower($tipo)} value='$valor'>
                </div>
            ";
        }
        return $template;
    }

    public function crearGridText($tipo)
    {
        $id = "";
        if ($tipo === 'Lingual') $id = 'id="text-lingual"';
        $template = "
            <div class='grid-item' $id >
                <div class='tipo-container'>$tipo</div>
            </div>
        ";
        return $template;
    }

    public function crearDientes($start, $end, $tipo, $reverse)
    {
        $oper = $start - $end;
        $template = '';
        for ($i = 0; $i < 8; $i++) {
            $dienteTemplate = $this->getDienteTemplate($start, $tipo, $reverse);
            if ($tipo === 'vestibular') {
                $template .= $dienteTemplate;
                if ($oper < 0) {
                    $start++;
                } else {
                    $start--;
                }
            } else {
                if ($i > 1 && $i < 8 - 1) {
                    $template .= $dienteTemplate;
                    if ($oper < 0) {
                        $start++;
                    } else {
                        $start--;
                    }
                }else{
                    $template.="
                        <div class='grid-item'>
                        </div>
                    ";
                }
            }
        }
        return $template;
    }
    public function getDienteTemplate($num, $tipo, $reverse)
    {
        $reverseClass = '';
        if ($reverse) $reverseClass = 'reverse';
        if ($tipo === 'vestibular') {
            return "<div class='grid-item'>
                        <div class='item-diente $reverseClass'>
                            <div class='diente-num'>$num</div>
                            <div class='diente-container'>
                                <div class='diente-simbo-container hover'></div>
                                <div class='diente' tipo='$tipo' num='$num'>"
                                .$this->getDienteImgBase64($tipo)."
                                </div>
                            </div>
                        </div>
                    </div>";
        } else {
            return "<div class='grid-item'>
                        <div class='item-diente $reverseClass'>
                            <div class='diente-num'>$num</div>
                            <div class='diente-container'>
                                <div class='diente-simbo-container hover'></div>
                                <div class='diente' tipo='$tipo' num='$num'>"
                                .$this->getDienteImgBase64($tipo)."
                                </div>
                            </div>
                        </div>
                    </div>";
        }
    }
    public function getDienteImgBase64($tipo)
    {
        $svgVestibular='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 102.41 102.41">
        <polygon side="top" class="btn-diente btn-diente-hover" points="1.21 1.21 26.21 26.21 76.21 26.21 101.21 1.21 1.21 1.21">
        </polygon>
        <polygon side="right" class="btn-diente btn-diente-hover" points="101.21 1.21 76.21 26.21 76.21 76.21 101.21 101.21 101.21 1.21">
        </polygon>
        <polygon side="left" class="btn-diente btn-diente-hover" points="1.21 1.21 26.21 26.21 26.21 76.21 1.21 101.21 1.21 1.21">
        </polygon>
        <polygon side="bottom" class="btn-diente btn-diente-hover" points="1.21 101.21 26.21 76.21 76.21 76.21 101.21 101.21 1.21 101.21">
        </polygon>
        <rect side="center" class="btn-diente btn-diente-hover" x="26.21" y="26.21" width="50" height="50">
        </rect>
    </svg>';
        
        $svgLingual='
                        <svg width="100%" height="100%" viewBox="-0.5 -0.5 105 105">
                            <line x1="68.18" y1="32.82" x2="85.86" y2="15.14"></line>
                            <line x1="32.82" y1="32.82" x2="15.14" y2="15.14"></line>
                            <path side="top" class="btn-diente btn-diente-hover" d="M32.82,32.82,15.14,15.14A49.21,49.21,0,0,1,50.5.5,49.21,49.21,0,0,1,85.86,15.14L68.18,32.82A23.85,23.85,0,0,0,50.5,25.5,23.85,23.85,0,0,0,32.82,32.82Z"></path>
                            <path side="right" class="btn-diente btn-diente-hover" d="M68.18,32.82,85.86,15.14A49.21,49.21,0,0,1,100.5,50.5,49.21,49.21,0,0,1,85.86,85.86L68.18,68.18A23.85,23.85,0,0,0,75.5,50.5,23.85,23.85,0,0,0,68.18,32.82Z"></path>
                            <path side="left" class="btn-diente btn-diente-hover" d="M32.82,68.18,15.14,85.86A49.21,49.21,0,0,1,.5,50.5,49.21,49.21,0,0,1,15.14,15.14L32.82,32.82A23.85,23.85,0,0,0,25.5,50.5,23.85,23.85,0,0,0,32.82,68.18Z"></path>
                            <path side="bottom" class="btn-diente btn-diente-hover" d="M68.18,68.18,85.86,85.86A49.21,49.21,0,0,1,50.5,100.5,49.21,49.21,0,0,1,15.14,85.86L32.82,68.18A23.85,23.85,0,0,0,50.5,75.5,23.85,23.85,0,0,0,68.18,68.18Z"></path>
                            <circle side="center" class="btn-diente btn-diente-hover" cx="50.5" cy="50.5" r="25"></circle>
                            <line x1="68.31" y1="68.31" x2="85.98" y2="85.98"></line>
                            <line x1="32.69" y1="68.31" x2="15.02" y2="85.98"></line>
                        </svg>
        ';
        if($tipo==='vestibular'){
            $img='<img src="data:image/svg+xml;base64,'. base64_encode($svgVestibular).'">';
        }else{
            $img='<img src="data:image/svg+xml;base64,'. base64_encode($svgLingual).'">';
        }
        return $img;
    }
}

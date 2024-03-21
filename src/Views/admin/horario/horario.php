<?=$this->fetch('../commons/header.php', $data)?>
<section class="<?=($data['informacoes']['menu_active'] === 'horarios') ? 'background-white' : ''?>">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Horários</p>
            </div>
            <div class="topo">
                <div class="btn">
                    <a href="<?=URL_BASE?>admin/servicos-create">Cadastrar novo</a>
                </div>
            </div> 
        </div>

        <div class="lista">
            <table>
                <tbody> 
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Domingo
                            </div>
                            <div class="valor-ser">
                                <?php 
                                    $horarios = $data['informacoes']['lista'][0]['domingo'];
                                    if($horarios === "Fechado"){
                                        echo "Fechado";
                                    } else{
                                        $turno = explode(" - ", $horarios);
                                        $turno1 = explode(", ", $turno[0]);
                                        $turno2 = explode(", ", $turno[1]);
    
                                        $mostrar = " ";
                                        if ($turno1 == " ") {
                                            $mostrar = " ";
                                        } else{
                                            $mostrar = " às ";
                                        }
    
                                        $mostrar2 = " ";
                                        if ($turno2 == " ") {
                                            $mostrar2 = " ";
                                        } else{
                                            $mostrar2 = " às ";
                                        }
                                        echo $turno1[0] . $mostrar . end($turno1) . "  ";
    
                                        echo $turno2[0] . $mostrar2 . end($turno2);
                                    }
                                ?> 
                               
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Segunda-Feira
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['segunda'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Terça-Feira
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['terca'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Quarta-Feira
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['quarta'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Quinta-Feira
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['quinta'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Sexta-Feira
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['sexta'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="titulo_item">
                            <div class="titulo-ser">
                                Sábado
                            </div>
                            <div class="valor-ser">
                            <?php 
                                $horarios = $data['informacoes']['lista'][0]['sabado'];
                                if($horarios === "Fechado"){
                                    echo "Fechado";
                                } else{
                                    $turno = explode(" - ", $horarios);
                                    $turno1 = explode(", ", $turno[0]);
                                    $turno2 = explode(", ", $turno[1]);

                                    $mostrar = " ";
                                    if ($turno1 == " ") {
                                        $mostrar = " ";
                                    } else{
                                        $mostrar = " às ";
                                    }

                                    $mostrar2 = " ";
                                    if ($turno2 == " ") {
                                        $mostrar2 = " ";
                                    } else{
                                        $mostrar2 = " às ";
                                    }
                                    echo $turno1[0] . $mostrar . end($turno1) . "  ";

                                    echo $turno2[0] . $mostrar2 . end($turno2);
                                }
                            ?> 
                            </div>
                        </td>
                        <td class="acao">
                            <div class="btn">
                                <a href="<?=URL_BASE?>admin/horarios-edit/">Editar</a>
                            </div>
                            <form action="<?=URL_BASE?>admin/horarios_delete" method="post">
                                <input type="hidden" name="id" value="">
                                <button type="submit"><i class="fa-solid fa-trash"></i></i></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="paginacao">
                <?php if(isset($data['informacoes']['paginaAnterior']) && $data['informacoes']['paginaAnterior'] !== false){?>
                    <a href="<?=$data['informacoes']['paginaAnterior'] ?>"><i class="fas fa-arrow-circle-left"></i></a>
                <?php }?>
                
                <span><?=$data['informacoes']['paginaAtual']?></span>

                <?php if(isset($data['informacoes']['proximaPagina']) && $data['informacoes']['proximaPagina'] !== false){?>
                    <a href="<?=$data['informacoes']['proximaPagina'] ?>"> <i class="fas fa-arrow-circle-right"></i></a>
                <?php }?>
            </div>
        </div>
    </div>
</section>
<?=$this->fetch('../commons/footer.php')?>
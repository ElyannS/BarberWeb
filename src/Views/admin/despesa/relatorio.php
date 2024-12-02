<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container"> 
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Despesa - Relatório</p>
            </div>
        </div>
        
        <div class="row1">
            <div class="col-1">
                <div class="w-49">
                    <label>
                        Período*
                        <input id="campoDataDespesa1" type="date" name="data" required>
                    </label>
                </div>
                <div class="w-49">
                    <label>
                        Período*
                        <input id="campoDataDespesa" type="date" name="data" required>
                    </label>
                </div>
            </div> 
        </div>
        
        <div class="row1">
            <div id="relato">

            </div>
           
           
            <div class="total">
                <div class="total-section">
                    <div id="dinheiroR"></div>
                </div>
                <div class="total-section">
                    <div id="pixR"></div>
                </div>
                <div class="total-section">
                    <div id="cartaoR"></div>
                </div>
                <div class="total-section">
                    <h1 id="valorTotal"></h1>
                </div>
                <div class="total-section">
                    <div id="saldo"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>    
//seta a data atual 
     document.getElementById("campoDataDespesa").value = value='<?php echo date("Y-m-d"); ?>';
     document.getElementById("campoDataDespesa1").value = value='<?php echo date("Y-m-d"); ?>';
</script>
<?=$this->fetch('../commons/footer.php', $data)?>
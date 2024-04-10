<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda">
    <div class="container">
        <div class="top-container">
            <div class="agenda-top"> 
                <div class="container-popup">
                    <div class="close-popup">
                        <i class="fa-solid fa-xmark close"></i>
                    </div>
                    <div class="opcao-popup">
                        <a href="#">Agendar</a>
                        <a href="#">Bloquear</a>
                    </div>    
                </div>
                <div class="menu-agenda">
                    <div class="title-menu">
                        <div class="icon-menu">
                            <i id="prevButton" class="fa-solid fa-angle-left"></i>
                            <input type="date" id="dataMarcada" class="hidden" />
                            <span class="calendarIcon"><i class="fa-solid fa-calendar-days"></i></span>
                        </div>
                        <div class="date"></div>
                        <i id="nextButton" class="fa-solid fa-angle-right"></i>
                    </div>
                    
                    <div class="calendar">
                        <div class="week">
                            <p>D</p>
                            <p>S</p>
                            <p>T</p>
                            <p>Q</p>
                            <p>Q</p>
                            <p>S</p>
                            <p>S</p>
                        </div>
                       
                        <div class="date_ext">
    
                        </div>
                    </div>
                    
                </div>
                <div id="tabelaHorarios">

                    
                </div>
            </div>
        </div>
        <div id="aviso">

        </div>
    </div>
</section>

<?=$this->fetch('../commons/footer.php')?>
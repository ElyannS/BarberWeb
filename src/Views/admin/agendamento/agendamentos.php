<?=$this->fetch('../commons/header.php', $data)?>
<section class="agenda">
    <div class="container">
        <div class="top-container">
            <div class="container-popup">
                <div class="close-popup">
                    <i class="fa-solid fa-xmark close"></i>
                </div>
                <div class="opcao-popup">
                    <a href="#">Agendar</a>
                    <a href="#">Bloquear</a>
                </div>    
        </div>
            <div class="agenda-top"> 
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
                <table>

                    <tr>
                        <th class="tr">07:00</th>
                        <td><div class="td" id="horario-07-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-07-30"></div></td>
                    </tr> 
                    <tr>
                        <th class="tr">08:00</th>
                        <td><div class="td" id="horario-08-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td"  id="horario-08-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">09:00</th>
                        <td><div class="td" id="horario-09-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-09-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">10:00</th>
                        <td ><div class="td"  id="horario-10-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-10-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">11:00</th>
                        <td><div class="td" id="horario-11-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-11-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">12:00</th>
                        <td><div class="td" id="horario-12-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-12-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">13:00</th>
                        <td><div class="td" id="horario-13-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-13-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">14:00</th>
                        <td><div class="td" id="horario-14-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-14-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">15:00</th>
                        <td><div class="td" id="horario-15-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-15-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">16:00</th>
                        <td><div class="td" id="horario-16-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-16-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">17:00</th>
                        <td><div class="td" id="horario-17-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td " id="horario-17-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">18:00</th>
                        <td><div class="td " id="horario-18-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td " id="horario-18-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">19:00</th>
                        <td><div class="td" id="horario-19-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-19-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">20:00</th>
                        <td><div class="td" id="horario-20-00"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">_</th>
                        <td><div class="td" id="horario-20-30"></div></td>
                    </tr>
                    <tr>
                        <th class="tr">21:00</th>
                        <td><div class="td" id="horario-21-00"></div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>

<?=$this->fetch('../commons/footer.php')?>
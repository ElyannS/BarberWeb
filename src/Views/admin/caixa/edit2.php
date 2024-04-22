<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Caixa - Editar  <?=date("d/m/Y", strtotime($data['informacoes']['dataUrl']))?></p>
            </div>
        </div>
    
        <div class="form">
            <form action="<?=URL_BASE?>admin/caixa_insert" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="w-80">
                        <label>
                            Nome Cliente*
                            <input type="text" name="nome_cliente" required>
                        </label>
                    </div>
                    <div class="w-20">
                    <label>
                            Data*
                            <input id="campoData" type="date" name="data"  value="<?=$data['informacoes']['dataUrl']?>" >
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="dinheiro" placeholder="Dinheiro" >
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="pix" placeholder="Pix" >
                    </label>
                </div>
                <div class="row">
                    <label>
                        Valor do Serviço
                        <input type="number" name="cartao" placeholder="Cartão" >
                    </label>
                </div>
                
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>

        <div class="transactions-list">
        <table>
            <thead>
                <tr>
                    <td class="actions">AÇÕES</td>
                    <td class="client-name">NOME CLIENTE</td>
                    <td class="cash">DINHEIRO</td>
                    <td class="pix">PIX</td>
                    <td class="card">CARTÃO</td>
                    <td class="date">DATA</td>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <td class="actions action-cell">
                        <div class="action-buttons">
                            <div class="button">
                                <a href="<?=URL_BASE?>admin/caixa-edit/<?=$caixa['id']?>">Editar <i class="far fa-edit"></i></a>
                            </div>
                            <div class="button">
                                <form action="<?=URL_BASE?>admin/caixa_delete" id="deleteForm" method="post">
                                    <input type="hidden" name="id" value="1">
                                    <button type="submit">Excluir <i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td class="client-name">Caique</td>
                    <td class="cash-amount">25</td>
                    <td class="pix-amount">0</td>
                    <td class="card-amount">0</td>
                    <td class="date">03/04/2024</td>
                </tr>
            </tbody>
        </table>
        <div class="total">
            <div class="total-section">
                Valor total do Dinheiro: R$ 25,00
            </div>
            <div class="total-section">
                Valor total do Pix: R$ 0,00
            </div>
            <div class="total-section">
                Valor total do Cartão: R$ 0,00
            </div>
            <div class="total-section">
                Valor total do dia: R$ 25,00
            </div>
        </div>
    </div>

</section>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao' );
</script>
<?=$this->fetch('../commons/footer.php')?>
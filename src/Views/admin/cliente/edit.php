<?=$this->fetch('../commons/header.php', $data)?>
<section class="dashboard background-white">
    <div class="container">
        <div class="titulo_pagina">
            <div class="titulo-migalha">
                <i class="fa-solid fa-circle"></i>
                <p>Clientes - Editar</p>
            </div>
        </div>
       
        <div class="form">
            <form action="<?=URL_BASE?>admin/clientes_update" method="post" enctype="multipart/form-data" class="form_ajax">
                <div class="row">
                    <label>
                        Primeiro Nome
                        <input type="text" name="first_name" required value="<?=$data['informacoes']['cliente']['first_name']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Último Nome
                        <input type="text" name="last_name" required value="<?=$data['informacoes']['cliente']['last_name']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Email
                        <input type="email" name="email" value="<?=$data['informacoes']['cliente']['email']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Telefone
                        <input type="tel" name="telefone" value="<?=$data['informacoes']['cliente']['telefone']?>">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Foto do Cliente
                        <input type="file" name="foto_usuario">
                    </label>
                    <div class="img">
                        <img src="<?=URL_BASE.$data['informacoes']['cliente']['foto_usuario']?>">
                        <label>
                            <input type="checkbox" name="excluir_foto_usuario">
                            Excluir imagem
                        </label>
                    </div>
                </div>
                <div class="row">
                    <p>Caso deseja alterar a senha atual, preencha os dois campos abaixo, caso não queira alterar, deixe em branco.</p>
                </div>
                <div class="row">
                    <label>
                        Senha
                        <input type="password" name="senha">
                    </label>
                </div>
                <div class="row">
                    <label>
                        Confirmar Senha
                        <input type="password" name="confirmar_senha">
                    </label>
                </div>
                <div class="row">
                    <button type="submit">Salvar</button>
                </div>   
               
                <input type="hidden" name="id" value="<?=$data['informacoes']['cliente']['id']?>">
                <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['cliente']['foto_usuario']?>">
                
                <div class="alerta"> </div>
            </form>  
        </div>
</section>
<?=$this->fetch('../commons/footer.php')?>
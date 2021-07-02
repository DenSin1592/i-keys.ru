<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalLoginLabel">Вход</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">
	                    	<i class="icon-close"></i>
	                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="form-modal">
                    <div class="form-group">
                        <label for="formLoginEmail" class="form-label" >Ваш E-mail</label>
                        <input type="email" id="formLoginEmail" class="form-control" required >
                    </div>

                    <div class="form-group">
                        <label for="formLoginPassword" class="form-label" >Пароль</label>
                        <div class="float-right">
                            <a href="#link">Забыли пароль?</a>
                        </div>
                        <input type="password" id="formLoginPassword" class="form-control" required >
                    </div>

                    <div class="form-row mt-4">
                        <div class="col-auto">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-sm" >Войти</button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mb-0">
                                <a href="#link" class="btn-outline btn-sm" >Регистрация</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_login.blade.php ENDPATH**/ ?>
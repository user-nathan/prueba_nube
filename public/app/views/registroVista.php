<?php 
// app/views/registroVista.php

$cssEspecifico = 'login.css'; 
// CORREGIDO: Ruta absoluta usando el DOCUMENT_ROOT del servidor
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/views/includes/header.php';  
?>

<div style="text-align: center; padding: 20px;">

    <div class="registro-container">
        <h2>Únete a la comunidad</h2>
        
        <?php if (isset($error)): ?>
            <p class="msg-error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="/registro" method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Crear cuenta</button>
        </form>
        
        <p class="msg-pie">¿Ya tienes cuenta? <a href="/login">Entra aquí</a></p>
    </div>

</div>

<?php 
// CORREGIDO: Inyectamos el cierre estructural de la página de forma segura
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/views/includes/footer.php'; 
?>
<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-03-25 00:32:49
         compiled from "vistas\peliculas_listado.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19412264915e7956dd52db23-40900863%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da009e44df3fe929dfd121e37a3153e89a9dc804' => 
    array (
      0 => 'vistas\\peliculas_listado.tpl',
      1 => 1585092763,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19412264915e7956dd52db23-40900863',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5e7956dd5b8f77_18968818',
  'variables' => 
  array (
    'url_base' => 0,
    'proyecto' => 0,
    'titulo' => 0,
    'mensaje' => 0,
    'peliculas' => 0,
    'audiovisual' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e7956dd5b8f77_18968818')) {function content_5e7956dd5b8f77_18968818($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
">
    <meta charset="utf-8">
    
    <title><?php echo $_smarty_tpl->tpl_vars['proyecto']->value;?>
</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap4.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/main.css" />
    
  </head>

  <body>
    <?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div class="container-fluid">
      <div class="row">
       
        <div class="col-sm-12  col-md-12  main">
          <h1 class="primary">Peliculas</h1>
          <h4 ><?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
</h2>
          <?php if ($_smarty_tpl->tpl_vars['mensaje']->value!='') {?>
            <div class="alert alert-danger" role="alert"><?php echo $_smarty_tpl->tpl_vars['mensaje']->value;?>
</div>
          <?php }?>
          <div class="row">
            <?php  $_smarty_tpl->tpl_vars['audiovisual'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['audiovisual']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['peliculas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['audiovisual']->key => $_smarty_tpl->tpl_vars['audiovisual']->value) {
$_smarty_tpl->tpl_vars['audiovisual']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['audiovisual']->key;
?>
            <div class="col">
              <div 
                class="card film" 
                id=<?php echo $_smarty_tpl->tpl_vars['audiovisual']->value["imdbID"];?>
 
                style="width: 18rem;"
                onclick="window.location ='<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
pelicula/detalles/<?php echo $_smarty_tpl->tpl_vars['audiovisual']->value['imdbID'];?>
'">
                <img src=<?php echo $_smarty_tpl->tpl_vars['audiovisual']->value["Poster"];?>
 class="card-img-top" alt="pelicula">
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo $_smarty_tpl->tpl_vars['audiovisual']->value['Year'];?>
 - <?php echo $_smarty_tpl->tpl_vars['audiovisual']->value['Title'];?>

                  </h5>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    
    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="js/bootstrap4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/funciones.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" scr="js/main.js"><?php echo '</script'; ?>
>
    
  </body>
</html>
<?php }} ?>

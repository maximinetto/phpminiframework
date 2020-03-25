<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-03-24 17:15:28
         compiled from "vistas\cabezal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:319098955e793c306d7750-58348862%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ad62bdcb8b662acda561a954aad315411c3ba5c' => 
    array (
      0 => 'vistas\\cabezal.tpl',
      1 => 1585066525,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '319098955e793c306d7750-58348862',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5e793c306e21c0_33257523',
  'variables' => 
  array (
    'proyecto' => 0,
    'url_base' => 0,
    'url_logout' => 0,
    'buscar' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e793c306e21c0_33257523')) {function content_5e793c306e21c0_33257523($_smarty_tpl) {?><nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $_smarty_tpl->tpl_vars['proyecto']->value;?>
</a>
          <ul class="nav navbar-nav">
            <li>
               <a href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
pelicula/listado">Peliculas</a>
            </li>
            <li>
              <a href="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
usuario/listado">Usuarios</a>
            </li>
          </ul>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['url_logout']->value;?>
">Cerrar Sesión</a></li>
          </ul>
          <form class="navbar-form navbar-right" method="post" action="<?php echo $_smarty_tpl->tpl_vars['url_base']->value;?>
usuario/buscar/">
            <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar..." value='<?php echo $_smarty_tpl->tpl_vars['buscar']->value;?>
'>
            <input type="submit" value="Buscar" class="form-control btn btn-primary">
          </form>
        </div>
      </div>
    </nav><?php }} ?>

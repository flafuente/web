<?php

use Phinx\Migration\AbstractMigration;

class Base extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */

    /**
     * Migrate Up.
     */
    public function up()
    {
        // capitulos
        $table = $this->table('capitulos');
        $table->addColumn('userId',           'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('programaId',       'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('estadoId',         'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('cdnId',            'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('cdnThumbnail',     'string',   array('limit' => 512, 'default' => null, 'null' => true))
              ->addColumn('thumbnail',        'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('temporada',        'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('episodio',         'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('titulo',           'string',   array('limit' => 128, 'default' => null, 'null' => true))
              ->addColumn('descripcion',      'text',     array('default' => null, 'null' => true))
              ->addColumn('duracion',         'time',     array('default' => null, 'null' => true))
              ->addColumn('visitas',          'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('likes',            'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('fechaEmision',     'date',     array('default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // capitulos_likes
        $table = $this->table('capitulos_likes');
        $table->addColumn('capituloId',       'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('ip',               'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // capitulos_visitas
        $table = $this->table('capitulos_visitas');
        $table->addColumn('capituloId',       'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('ip',               'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // categorias
        $table = $this->table('categorias');
        $table->addColumn('visible',          'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('order',            'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('nombre',           'string',   array('limit' => 50))
              ->addColumn('wistiaHash',       'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('hashtag',          'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('slug',             'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('menuImage',        'string',   array('limit' => 100, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // comunidades
        $table = $this->table('comunidades');
        $table->addColumn('nombre',           'string',   array('limit' => 100))
              ->save();

        // contactos
        $table = $this->table('contactos');
        $table->addColumn('userId',           'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('nombre',           'string',   array('limit' => 128, 'default' => null, 'null' => true))
              ->addColumn('email',            'string',   array('limit' => 128, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // contactos_categorias
        $table = $this->table('contactos_categorias');
        $table->addColumn('contactoId',       'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('categoriaId',      'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // devices
        $table = $this->table('devices');
        $table->addColumn('typeId',           'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('userId',           'integer',  array('limit' => 11))
              ->addColumn('pushToken',        'text',     array('default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('lastVisitDate',    'datetime', array('default' => null, 'null' => true))
              ->save();

        // eventos
        $table = $this->table('eventos');
        $table->addColumn('userId',           'integer',  array('limit' => 11))
              ->addColumn('capituloId',       'integer',  array('limit' => 11))
              ->addColumn('fechaInicio',      'datetime', array('default' => null, 'null' => true))
              ->addColumn('fechaFin',         'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // programas
        $table = $this->table('programas');
        $table->addColumn('seccionId',        'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('userId',           'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('estadoId',         'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('destacado',        'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('color',            'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('banner',           'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('thumbnail',        'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('titulo',           'string',   array('limit' => 150, 'default' => null, 'null' => true))
              ->addColumn('subtitulo',        'string',   array('limit' => 256, 'default' => null, 'null' => true))
              ->addColumn('descripcion',      'text',     array('default' => null, 'null' => true))
              ->addColumn('slug',             'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('visitas',          'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('likes',            'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // secciones
        $table = $this->table('secciones');
        $table->addColumn('visible',          'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('order',            'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('nombre',           'string',   array('limit' => 50))
              ->addColumn('hashtag',          'string',   array('limit' => 128, 'default' => null, 'null' => true))
              ->addColumn('thumbnail',        'string',   array('limit' => 512, 'default' => null, 'null' => true))
              ->addColumn('slug',             'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('menuImage',        'string',   array('limit' => 100, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // tags
        $table = $this->table('tags');
        $table->addColumn('tags',             'string',   array('limit' => 50))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // users
        $table = $this->table('users');
        $table->addColumn('statusId',         'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('verified',         'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('roleId',           'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('permisos',         'text',     array('null' => true))
              ->addColumn('categorias',       'text',     array('null' => true))
              ->addColumn('username',         'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('nombre',           'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('apellidos',        'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('email',            'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('password',         'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('recoveryHash',     'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('verificationHash', 'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('foto',             'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('ubicacion',        'string',   array('limit' => 256, 'default' => null, 'null' => true))
              ->addColumn('biografia',        'text',     array('null' => true))
              ->addColumn('intereses',        'text',     array('null' => true))
              ->addColumn('sitios',           'text',     array('null' => true))
              ->addColumn('telefono',         'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('token',            'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('wsToken',          'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('lastvisitDate',    'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // videos
        $table = $this->table('videos');
        $table->addColumn('userId',           'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('videoArchivoId',   'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('estadoId',         'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('estadoCdnId',      'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('cdnId',            'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('thumbnail',        'string',   array('limit' => 512, 'default' => null, 'null' => true))
              ->addColumn('categoriaId',      'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('titulo',           'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('descripcion',      'text',     array('null' => true))
              ->addColumn('texto',            'text',     array('null' => true))
              ->addColumn('comunidadId',      'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('localizacion',     'text',     array('null' => true))
              ->addColumn('long',             'text',     array('null' => true))
              ->addColumn('lat',              'text',     array('null' => true))
              ->addColumn('visitas',          'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('dateUpdate',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // videos_archivos
        $table = $this->table('videos_archivos');
        $table->addColumn('videoId',            'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('userId',             'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('estadoId',           'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('estadoConversionId', 'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('comentario',         'text',     array('null' => true))
              ->addColumn('file',               'string',   array('limit' => 256, 'default' => null, 'null' => true))
              ->addColumn('url',                'string',   array('limit' => 512, 'default' => null, 'null' => true))
              ->addColumn('size',               'integer',  array('limit' => 11, 'default' => 0, 'null' => true))
              ->addColumn('type',               'string',   array('limit' => 50, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',         'datetime', array('default' => null, 'null' => true))
              ->addColumn('dateUpdate',         'datetime', array('default' => null, 'null' => true))
              ->save();

        // videos_likes
        $table = $this->table('videos_likes');
        $table->addColumn('capituloId',       'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('ip',               'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // videos_tags
        $table = $this->table('videos_tags');
        $table->addColumn('videoId',          'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('tagId',            'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();

        // videos_visitas
        $table = $this->table('videos_visitas');
        $table->addColumn('videoId',          'integer',  array('limit' => 11, 'default' => 0))
              ->addColumn('ip',               'string',   array('limit' => 32, 'default' => null, 'null' => true))
              ->addColumn('dateInsert',       'datetime', array('default' => null, 'null' => true))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}

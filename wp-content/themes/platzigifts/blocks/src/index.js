import { registerBlockType } from '@wordpress/blocks';

registerBlockType(
	'pg/basic', // pg/basic tiene que ser igual al php
	{
		title       : 'Basic Block',
		description : 'Este es nuestro primer bloque',
		icon        : 'smiley',                                     // optener de la libreria dashicon
		category    : 'layout',
		edit        : () => <h2>Hola Mundo</h2>,
		save        : () => <h2>Hola Mundo</h2>
	}
)

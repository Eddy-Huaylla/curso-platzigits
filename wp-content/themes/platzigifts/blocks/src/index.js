import { registerBlockType } from '@wordpress/blocks';
import { TextControl } from '@wordpress/components'

registerBlockType(
	'pg/basic', // pg/basic tiene que ser igual al php
	{
		title       : 'Basic Block',
		description : 'Este es nuestro primer bloque',
		icon        : 'smiley',                          // optener de la libreria dashicon
		category    : 'layout',
		attributes  : {
			content : {
				type    : "string",
				default : "Hello World"
			}
		},
		edit        : ( props ) => {
			const { attributes: { content }, setAttributes, className, isSelected } = props;

			const handlerOnChangeInput = newContent => {
				setAttributes({ content: newContent })
			}

			return <TextControl
					label    = "Complete el campo"
					value    = {content}
					onChange = {handlerOnChangeInput}
					/>
		},
		save        : ( props ) => {
            return <h2>{ props.attributes.content }</h2>
		}
	}
)

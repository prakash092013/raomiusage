/**
 * Import the stylesheet for the plugin.
 */
import './style/index.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
import { useEffect, useState } from "@wordpress/element";
import apiFetch from '@wordpress/api-fetch';

import {
	ToggleControl,
	PanelBody,
} from '@wordpress/components';
import {
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';

registerBlockType( 'raomi/demotable', {
	title: 'Miusage API',
    icon: 'universal-access-alt',
    category: 'design',
    attributes: {
        hideId: { type: 'boolean' },
		hideFirstName: { type: 'boolean' },
		hideLastName: { type: 'boolean' },
		hideEmail: { type: 'boolean' },
		hideDate: { type: 'boolean' }
	},

    edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps();
		const {
			hideId,
			hideFirstName,
			hideLastName,
			hideEmail,
			hideDate,
		} = attributes;

		function onChangeToggleID( newValue ) {
			setAttributes( { hideId: newValue } );
		}
		function onChangeToggleFirstName( newValue ) {
			setAttributes( { hideFirstName: newValue } );
		}
		function onChangeToggleLastName( newValue ) {
			setAttributes( { hideLastName: newValue } );
		}
		function onChangeToggleEmail( newValue ) {
			setAttributes( { hideEmail: newValue } );
		}
		function onChangeToggleDate( newValue ) {
			setAttributes( { hideDate: newValue } );
		}
		const [data, setData] = useState();
		const [isBusy, setBusy] = useState(true)

		// Call to ajax end point
		useEffect(() => {
			async function fetchData() {
				apiFetch( { path: '/raomi/v1/usage' } )
				.then( ( response ) => {
					let newData = response.data;
					setBusy(false);
					setData(newData)
					// setAttributes( { tableRows: newData } );
				})
				.catch((err) => console.error(err));
			}
			fetchData();
		}, [])
		
		return (
            
			<div { ...blockProps }>
				{ isBusy ? (
					<div>{__('Loading Data', 'raomi')}</div>
				) : (
					<div className='raomi-table'>
						<table cellPadding={5} cellSpacing={10}>
							<tr>
								{ !hideId ? <td><strong>{__('ID', 'raomi')}</strong></td> : null }
								{ !hideFirstName ? <td><strong>{__('First Name', 'raomi')}</strong></td> : null }
								{ !hideLastName ? <td><strong>{__('Last Name', 'raomi')}</strong></td> : null }
								{ !hideEmail ? <td><strong>{__('Email', 'raomi')}</strong></td> : null }
								{ !hideDate ? <td><strong>{__('Date', 'raomi')}</strong></td> : null }
							</tr>
							{data && data.map((row, index) => {
								return (
									<tr key={index}>
										{ !hideId ? <td>{row.id}</td> : null }
										{ !hideFirstName ? <td>{row.fname}</td> : null }
										{ !hideLastName ? <td>{row.lname}</td> : null }
										{ !hideEmail ? <td>{row.email}</td> : null }
										{ !hideDate ? <td>{row.date}</td> : null }
									</tr>
								);
							})}
						</table>
					</div>
				)}
				<InspectorControls>
					<PanelBody title={ __( 'Table column settings' ) }>
						<ToggleControl
							label={__('Hide ID', 'raomi')}
							checked={ hideId }
							onChange={ onChangeToggleID }
						/>
						<ToggleControl
							label={__('Hide First Name', 'raomi')}
							checked={ hideFirstName }
							onChange={ onChangeToggleFirstName }
						/>
						<ToggleControl
							label={__('Hide Last Name', 'raomi')}
							checked={ hideLastName }
							onChange={ onChangeToggleLastName }
						/>
						<ToggleControl
							label={__('Hide Email', 'raomi')}
							checked={ hideEmail }
							onChange={ onChangeToggleEmail }
						/>
						<ToggleControl
							label={__('Hide Date', 'raomi')}
							checked={ hideDate }
							onChange={ onChangeToggleDate }
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		);
	},

	save( { attributes } ) {
		// Dynamic block rendering defined in class-raomi-init-blocks.php
		return null;
	},
    
} );
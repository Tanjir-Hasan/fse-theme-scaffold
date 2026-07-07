/**
 * Site Editor sidebar: "{{THEME_NAME}} Settings".
 *
 * A global (not per-page) settings panel, only registered on site-editor.php
 * (see includes/scripts.php -> enqueue_editor_scripts). Reads/writes the
 * `{{PFX}}_theme_options` option via the REST route registered in
 * includes/admin/settings.php.
 *
 * Built with `npm run build` (see webpack.config.js) into build/settings.js.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginSidebar } from '@wordpress/edit-site';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { useState, useEffect, useCallback, Fragment } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';

const ENDPOINT = '{{PFX}}/v1/global_settings';

const pluginIcon = (
	<svg
		className="{{SLUG}}-page-settings-button"
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
		fill="none"
	>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M16.2,0.4H5.8c-2.9,0-5.3,2.4-5.3,5.4v10.5c0,3,2.4,5.4,5.3,5.4h10.5c3,0,5.3-2.4,5.3-5.4V5.8C21.6,2.8,19.2,0.4,16.2,0.4z M11,17.2c-3.4,0-6.2-2.8-6.2-6.2c0-1.1,0.3-2.2,0.9-3.2l1.7,1.7C7.3,10,7.2,10.5,7.2,11c0,2.1,1.7,3.8,3.8,3.8c0.5,0,1-0.1,1.4-0.3l1.7,1.7C13.2,16.9,12.1,17.2,11,17.2z M9.2,11c0-1,0.8-1.8,1.8-1.8c1,0,1.8,0.8,1.8,1.8S12,12.8,11,12.8C10,12.8,9.2,12,9.2,11z M17.2,16.8l-3.3-3.3c0.6-0.7,1-1.6,1-2.5c0-2.1-1.7-3.8-3.8-3.8c-0.9,0-1.8,0.3-2.5,1L6.8,6.5C8,5.4,9.4,4.8,11,4.8c3.4,0,6.2,2.8,6.2,6.2V16.8z"
		/>
	</svg>
);

const ToggleSetting = ( { setting, setSetting, saveSetting, id, notice, label } ) => {
	const handleChange = useCallback( () => {
		const nextSetting = { ...setting, [ id ]: ! setting[ id ] };
		setSetting( nextSetting );
		saveSetting( nextSetting );
		dispatch( 'core/notices' ).createNotice( 'success', notice, {
			type: 'snackbar',
			isDismissible: true,
		} );
	}, [ setting ] );

	return (
		<PanelRow>
			<ToggleControl label={ label } checked={ !! setting[ id ] } onChange={ handleChange } />
		</PanelRow>
	);
};

const SettingsPanel = () => {
	const [ settings, setSettings ] = useState( { scroll_top: false } );

	useEffect( () => {
		( async () => {
			try {
				const data = await apiFetch( { path: ENDPOINT, method: 'GET' } );
				if ( data ) {
					setSettings( data );
				}
			} catch ( error ) {
				// eslint-disable-next-line no-console
				console.error( error );
			}
		} )();
	}, [] );

	const saveSetting = async ( data ) => {
		try {
			await apiFetch( {
				path: ENDPOINT,
				method: 'POST',
				data: { setting: data },
			} );
		} catch ( error ) {
			// eslint-disable-next-line no-console
			console.error( error );
		}
	};

	return (
		<PanelBody title={ __( '{{THEME_NAME}} Settings', '{{SLUG}}' ) } initialOpen>
			<ToggleSetting
				setting={ settings }
				setSetting={ setSettings }
				saveSetting={ saveSetting }
				id="scroll_top"
				notice={ __( 'Scroll to top updated', '{{SLUG}}' ) }
				label={ __( 'Scroll To Top', '{{SLUG}}' ) }
			/>
		</PanelBody>
	);
};

registerPlugin( '{{PFX}}-editor-sidebar', {
	render: () => (
		<Fragment>
			<PluginSidebar name="{{PFX}}-editor-sidebar" icon={ pluginIcon } isPinnable title={ __( '{{THEME_NAME}} Editor Settings', '{{SLUG}}' ) }>
				<SettingsPanel />
			</PluginSidebar>
		</Fragment>
	),
} );

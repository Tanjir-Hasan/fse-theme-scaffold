/**
 * Post/page editor sidebar: "{{THEME_NAME}} Page Settings".
 *
 * Adds a sidebar panel with per-page toggles (sticky/transparent header,
 * hide header/footer) backed by the post meta registered in
 * includes/core/metabox.php, plus a per-block "Hide on Desktop/Tablet/Mobile"
 * control added to every block's Inspector Controls.
 *
 * Built with `npm run build` (see webpack.config.js) into build/editor.js.
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { withSelect, withDispatch, useSelect, useDispatch } from '@wordpress/data';
import { compose, createHigherOrderComponent } from '@wordpress/compose';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';

const disableSections = window.{{LOC}}?.disable_sections || [];

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
			d="M16.2,0.4H5.8c-2.9,0-5.3,2.4-5.3,5.4v10.5c0,3,2.4,5.4,5.3,5.4h10.5c3,0,5.3-2.4,5.3-5.4V5.8 C21.6,2.8,19.2,0.4,16.2,0.4z M11,17.2c-3.4,0-6.2-2.8-6.2-6.2c0-1.1,0.3-2.2,0.9-3.2l1.7,1.7C7.3,10,7.2,10.5,7.2,11 c0,2.1,1.7,3.8,3.8,3.8c0.5,0,1-0.1,1.4-0.3l1.7,1.7C13.2,16.9,12.1,17.2,11,17.2z M9.2,11c0-1,0.8-1.8,1.8-1.8c1,0,1.8,0.8,1.8,1.8 S12,12.8,11,12.8C10,12.8,9.2,12,9.2,11z M17.2,16.8l-3.3-3.3c0.6-0.7,1-1.6,1-2.5c0-2.1-1.7-3.8-3.8-3.8c-0.9,0-1.8,0.3-2.5,1 L6.8,6.5C8,5.4,9.4,4.8,11,4.8c3.4,0,6.2,2.8,6.2,6.2V16.8z"
		/>
	</svg>
);

/**
 * Sticky / transparent header toggles — mutually exclusive.
 */
const HeaderToggleControls = ( { meta, setMetaFieldValue } ) => {
	const isSticky = !! meta?.[ '_{{PFX}}_meta_sticky_header' ];
	const isTransparent = !! meta?.[ '_{{PFX}}_meta_transparent_header' ];

	return (
		<Fragment>
			{ ! isTransparent && (
				<PanelRow>
					<ToggleControl
						label={ __( 'Enable Sticky Header', '{{SLUG}}' ) }
						checked={ isSticky }
						onChange={ ( value ) => setMetaFieldValue( value, '_{{PFX}}_meta_sticky_header' ) }
					/>
				</PanelRow>
			) }
			{ ! isSticky && (
				<PanelRow>
					<ToggleControl
						label={ __( 'Enable Transparent Header', '{{SLUG}}' ) }
						checked={ isTransparent }
						onChange={ ( value ) => setMetaFieldValue( value, '_{{PFX}}_meta_transparent_header' ) }
					/>
				</PanelRow>
			) }
		</Fragment>
	);
};

const DisableSectionPanel = ( { meta, setMetaFieldValue } ) => (
	<Fragment>
		<PanelBody title={ __( 'Disable Elements', '{{SLUG}}' ) } initialOpen>
			{ disableSections.map( ( section ) => (
				<PanelRow key={ section.key }>
					<ToggleControl
						label={ section.label }
						checked={ !! meta?.[ section.key ] }
						onChange={ ( value ) => setMetaFieldValue( value, section.key ) }
					/>
				</PanelRow>
			) ) }
		</PanelBody>
		{ ! meta?.[ '_{{PFX}}_meta_header_display' ] && (
			<PanelBody title={ __( 'Header Settings', '{{SLUG}}' ) } initialOpen>
				<HeaderToggleControls meta={ meta } setMetaFieldValue={ setMetaFieldValue } />
			</PanelBody>
		) }
	</Fragment>
);

const PageSettingsSidebar = compose(
	withSelect( ( select ) => ( {
		meta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
	} ) ),
	withDispatch( ( dispatch ) => ( {
		setMetaFieldValue: ( value, key ) => {
			dispatch( 'core/editor' ).editPost( { meta: { [ key ]: value } } );
		},
	} ) )
)( ( props ) => (
	<Fragment>
		<PluginSidebarMoreMenuItem target="{{PFX}}-page-settings-panel" icon={ pluginIcon }>
			{ __( '{{THEME_NAME}} Page Settings', '{{SLUG}}' ) }
		</PluginSidebarMoreMenuItem>
		<PluginSidebar
			name="{{PFX}}-page-settings-panel"
			title={ __( '{{THEME_NAME}} Page Settings', '{{SLUG}}' ) }
			icon={ pluginIcon }
		>
			<DisableSectionPanel { ...props } />
		</PluginSidebar>
	</Fragment>
) );

registerPlugin( '{{PFX}}-page-settings', { render: PageSettingsSidebar } );

/**
 * Per-block "hide on device" inspector control. Writes plain CSS classes
 * (see includes/core/responsive.php for the matching frontend @media rules),
 * so it works immediately with no extra save-time processing.
 */
const DEVICES = [ 'Desktop', 'Tablet', 'Mobile' ];
const HIDE_CLASS = {
	Desktop: '{{SLUG}}-hide-desktop',
	Tablet: '{{SLUG}}-hide-tablet',
	Mobile: '{{SLUG}}-hide-mobile',
};
const HIDE_CLASSES = Object.values( HIDE_CLASS );
const withoutHideClasses = ( className = '' ) =>
	className.split( /\s+/ ).filter( Boolean ).filter( ( cls ) => ! HIDE_CLASSES.includes( cls ) );

const ResponsiveVisibilityControls = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		const className = props.attributes.className || '';
		const active = DEVICES.filter( ( device ) => className.includes( HIDE_CLASS[ device ] ) );

		const toggle = ( device, value ) => {
			const next = value ? [ ...new Set( [ ...active, device ] ) ] : active.filter( ( d ) => d !== device );
			const nextClassName = [ ...withoutHideClasses( className ), ...next.map( ( d ) => HIDE_CLASS[ d ] ) ]
				.join( ' ' )
				.trim();
			props.setAttributes( { className: nextClassName } );
		};

		if ( ! props.isSelected ) {
			return <BlockEdit { ...props } />;
		}

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title={ __( '{{THEME_NAME}} Responsive Setting', '{{SLUG}}' ) } initialOpen={ false }>
						{ DEVICES.map( ( device ) => (
							<ToggleControl
								key={ device }
								label={ __( 'Hide on ' + device, '{{SLUG}}' ) }
								checked={ active.includes( device ) }
								onChange={ ( value ) => toggle( device, value ) }
							/>
						) ) }
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	},
	'ResponsiveVisibilityControls'
);

addFilter( 'editor.BlockEdit', '{{PFX}}/responsive-panel', ResponsiveVisibilityControls );

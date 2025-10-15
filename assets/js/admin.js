(function ($) {
	function efActivate(hash) {
		var $tabs  = $( '#edgeframe-tabs .nav-tab' );
		var $panes = $( '.ef-tab' );
		$tabs.removeClass( 'nav-tab-active' );
		$panes.hide();

		var $tab  = $tabs.filter( '[href="' + hash + '"]' );
		var $pane = $( hash );
		if ($tab.length && $pane.length) {
			$tab.addClass( 'nav-tab-active' );
			$pane.fadeIn( 120 );
			try {
				localStorage.setItem( 'ef.activeTab', hash );
			} catch (e) {
			}
			history.replaceState( null, '', hash );
		}
	}

	function efInitTabs() {
		var $first = $( '#edgeframe-tabs .nav-tab' ).first();
		var stored = null;
		try {
			stored = localStorage.getItem( 'ef.activeTab' );
		} catch (e) {
		}

		var start =
		location.hash && $( location.hash ).length
		? location.hash
		: stored && $( stored ).length
		? stored
		: $first.attr( 'href' );
		efActivate( start );

		$( '#edgeframe-tabs .nav-tab' ).on(
			'click',
			function (e) {
				e.preventDefault();
				efActivate( $( this ).attr( 'href' ) );
			}
		);
	}

	function efInitMedia() {
		$( document ).on(
			'click',
			'.ef-media-upload',
			function (e) {
				e.preventDefault();
				var $wrap = $( this ).closest( '.ef-media' );
				var frame = wp.media( { title: 'Select Image', multiple: false } );
				frame.on(
					'select',
					function () {
						var att = frame.state().get( 'selection' ).first().toJSON();
						$wrap.find( 'input[type="hidden"]' ).val( att.id );
						var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
						$wrap.find( '.ef-media-preview' ).html( '<img alt="" src="' + thumb + '" />' );
					}
				);
				frame.open();
			}
		);
	}

	function efInitColors() {
		if (typeof $.fn.wpColorPicker === 'function') {
			$( '.ef-color' ).wpColorPicker();
		}
	}

	function efBeautifyToggles() {
		// Convert checkboxes in toggle fields into pretty toggles
		$( 'input[type="checkbox"]' ).each(
			function () {
				var $cb = $( this );
				if ($cb.closest( '.ef-toggle' ).length) {
					return;
				}
				if ( ! $cb.closest( 'td' ).length) {
					return;
				}
				var isEfToggle = $cb.attr( 'name' ) && $cb.attr( 'name' ).indexOf( 'edgeframe_settings[' ) === 0;
				if ( ! isEfToggle) {
					return;
				}

				var checked = $cb.is( ':checked' ) ? 'checked' : '';
				var $wrap   = $( '<label class="ef-toggle"></label>' );
				var $track  = $( '<span class="track"></span>' );
				var $thumb  = $( '<span class="thumb"></span>' );
				$cb.after( $wrap );
				$wrap.append( $cb );
				$wrap.append( $track );
				$wrap.append( $thumb );
				$cb.prop( 'checked', checked === 'checked' );
			}
		);
	}

	function efInitRepeater() {
		function efEscapeRegExp(str) {
			return str.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
		}

		function efReindexRepeater($wrap) {
			var base = $wrap.data( 'name' );
			if ( ! base) {
				return;
			}
			var baseRE = new RegExp( '^' + efEscapeRegExp( base ) + '\\[[^\\]]+\\]' );
			$wrap.find( '.ef-repeater-item' ).each(
				function (i) {
					$( this )
					.find(
						'input[name^="' +
						base +
						'"], select[name^="' +
						base +
						'"], textarea[name^="' +
						base +
						'"]'
					)
					.each(
						function () {
							var name = $( this ).attr( 'name' );
							if ( ! name) {
								return;
							}
							var newName = name.replace( baseRE, base + '[' + i + ']' );
							$( this ).attr( 'name', newName );
						}
					);
				}
			);
		}

		// Add item
		$( document ).on(
			'click',
			'.ef-repeater .ef-repeater-add',
			function (e) {
				e.preventDefault();
				var $wrap = $( this ).closest( '.ef-repeater' );
				var tpl   = $wrap.find( '.ef-repeater-tpl' ).html();
				if ( ! tpl) {
					return;
				}
				// Generate index
				var next = $wrap.find( '.ef-repeater-item' ).length;
				tpl      = tpl.replaceAll( '__i__', String( next ) );
				$wrap.find( '.ef-repeater-items' ).append( tpl );
				// Set draggable if HTML5 fallback is active
				if ( ! $().sortable || ! $().sortable.name) {
					var $list = $wrap.find( '.ef-repeater-items' );
					if ($list.attr( 'data-ef-h5' ) === '1') {
						$list.children( '.ef-repeater-item' ).last().attr( 'draggable', 'true' );
					}
				}
				efReindexRepeater( $wrap );
				efEvaluateConditions( $( document ) );
			}
		);

		// Remove item
		$( document ).on(
			'click',
			'.ef-ri-remove',
			function (e) {
				e.preventDefault();
				var $item = $( this ).closest( '.ef-repeater-item' );
				var $wrap = $( this ).closest( '.ef-repeater' );
				$item.remove();
				efReindexRepeater( $wrap );
				efEvaluateConditions( $( document ) );
			}
		);

		// Sortable (if jQuery UI available)
		try {
			if ($.fn.sortable) {
				$( '.ef-repeater-items' ).sortable(
					{
						handle: '.ef-ri-move',
						axis: 'y',
						stop: function (e, ui) {
							efReindexRepeater( $( this ).closest( '.ef-repeater' ) );
						},
					}
				);
			} else {
				// Lightweight fallback using HTML5 Drag & Drop
				$( '.ef-repeater-items' ).each(
					function () {
						var $list = $( this );
						$list.attr( 'data-ef-h5', '1' );
						$list.children( '.ef-repeater-item' ).attr( 'draggable', 'true' );
						var dragEl = null;
						$list.on(
							'dragstart',
							'.ef-repeater-item',
							function (e) {
								dragEl                                     = this;
								e.originalEvent.dataTransfer.effectAllowed = 'move';
								$( this ).addClass( 'is-dragging' );
							}
						);
						$list.on(
							'dragend',
							'.ef-repeater-item',
							function () {
								$( this ).removeClass( 'is-dragging' );
								dragEl = null;
								efReindexRepeater( $list.closest( '.ef-repeater' ) );
							}
						);
						$list.on(
							'dragover',
							'.ef-repeater-item',
							function (e) {
								e.preventDefault();
								e.originalEvent.dataTransfer.dropEffect = 'move';
								var $target                             = $( this );
								if ( ! dragEl || dragEl === this) {
									return;
								}
								var targetRect = this.getBoundingClientRect();
								var midpoint   = targetRect.top + targetRect.height / 2;
								if (e.originalEvent.clientY < midpoint) {
									$target.before( dragEl );
								} else {
									$target.after( dragEl );
								}
							}
						);
						$list.on(
							'dragstart',
							'.ef-repeater-item',
							function (e) {
								try {
									e.originalEvent.dataTransfer.setData( 'text/plain', '' );
								} catch (err) {
								}
							}
						);
					}
				);
			}
		} catch (e) {
		}
	}

	function efInitRadioImage() {
		$( document ).on(
			'click',
			'.ef-radio-image',
			function () {
				var $label = $( this );
				var $input = $label.find( 'input[type="radio"]' );
				$input.prop( 'checked', true ).trigger( 'change' );
				$label.closest( '.ef-radio-image-group' ).find( '.ef-radio-image' ).removeClass( 'is-checked' );
				$label.addClass( 'is-checked' );
			}
		);
		// Mark initially-checked
		$( '.ef-radio-image-group' ).each(
			function () {
				var $g = $( this );
				var $c = $g.find( 'input[type="radio"]:checked' );
				if ($c.length) {
					$g.find( '.ef-radio-image' ).removeClass( 'is-checked' );
					$c.closest( '.ef-radio-image' ).addClass( 'is-checked' );
				}
			}
		);
	}

	function efInitSearch() {
		var $input = $( '#ef-search' );
		if ( ! $input.length) {
			return;
		}
		$input.on(
			'input',
			function () {
				var q = $( this ).val().toLowerCase();
				$( '.ef-section' ).each(
					function () {
						var $sec = $( this );
						var hit  = false;
						$sec.find( 'th, label, .description' ).each(
							function () {
								if ($( this ).text().toLowerCase().indexOf( q ) > -1) {
									hit = true;
								}
							}
						);
						$sec.toggle( hit || q.length === 0 );
					}
				);
			}
		);
	}

	// Conditional show_if: evaluate rules and toggle visibility
	function efEvaluateConditions($root) {
		$root    = $root || $( document );
		var opts = {}; // collect current values
		$( '[name^="edgeframe_settings["]', document ).each(
			function () {
				var $f   = $( this );
				var name = $f.attr( 'name' );
				var m    = name && name.match( /^edgeframe_settings\[([^\]]+)\]/ );
				if ( ! m) {
					return;
				}
				var key = m[1];
				var val;
				if ($f.is( ':checkbox' )) {
					val = $f.is( ':checked' ) ? 1 : 0;
				} else if ($f.is( ':radio' )) {
					if ($f.is( ':checked' )) {
						val = $f.val();
					} else {
						return;
					}
				} else {
					val = $f.val();
				}
				opts[key] = val;
			}
		);
		var check = function (rule) {
			var f = rule.field;
			var v = opts[f];
			if (rule.hasOwnProperty( 'equals' )) {
				return String( v ) === String( rule.equals );
			}
			if (rule.hasOwnProperty( 'notEquals' )) {
				return String( v ) !== String( rule.notEquals );
			}
			if (rule.truthy !== undefined) {
				return ! ! Number( v ) === ! ! rule.truthy;
			}
			if (rule.falsy !== undefined) {
				return ! ! Number( v ) === ! rule.falsy;
			}
			return true;
		};
		$( '[data-show-if]', document ).each(
			function () {
				var $el = $( this );
				var rules;
				try {
					rules = JSON.parse( $el.attr( 'data-show-if' ) || '[]' );
				} catch (e) {
					rules = [];
				}
				if ( ! Array.isArray( rules )) {
					rules = [rules];
				}
				var visible = rules.every( check );
				var $target = $el.closest( 'tr' ).length ? $el.closest( 'tr' ) : $el;
				$target.toggleClass( 'ef-hidden', ! visible );
			}
		);
	}

	function efBindConditionSources() {
		$( document ).on(
			'change input',
			'[name^="edgeframe_settings["]',
			function () {
				efEvaluateConditions( $( document ) );
			}
		);
	}

	// Toast notifications
	function efToast(msg, type) {
		type   = type || 'success';
		var $c = $( '.ef-toast-container' );
		if ( ! $c.length) {
			$c = $( '<div class="ef-toast-container"/>' ).appendTo( 'body' );
		}
		var $t = $(
			'<div class="ef-toast ef-toast--' +
			type +
			'">\
      <span class="ef-toast__icon">' +
			(type === 'error' ? '⚠️' : '✅') +
			'</span>\
      <div class="ef-toast__msg"></div>\
      <button class="ef-toast__close" aria-label="Close">✕</button>\
    </div>'
		);
		$t.find( '.ef-toast__msg' ).text( msg );
		$t.appendTo( $c );
		var remove = function () {
			$t.fadeOut(
				120,
				function () {
					$t.remove();
				}
			);
		};
		$t.find( '.ef-toast__close' ).on( 'click', remove );
		setTimeout( remove, 4000 );
	}

	function efInitToastsFromQuery() {
		var params = new URLSearchParams( window.location.search );
		var status = params.get( 'ef_status' );
		// Align with settings-page.php emitted ef_status values
		if (status === 'imported') {
			efToast( 'Settings imported successfully.', 'success' );
		}
		if (status === 'reset') {
			efToast( 'Settings reset to defaults.', 'success' );
		}
		if (status === 'no_file') {
			efToast( 'No file selected for import.', 'error' );
		}
		if (status === 'invalid_json') {
			efToast( 'The uploaded file is not valid JSON.', 'error' );
		}
		if (params.get( 'settings-updated' ) === 'true') {
			efToast( 'Settings saved.', 'success' );
		}
	}

	function efInitSelect2() {
		try {
			if ($.fn.select2) {
				$( 'select.ef-select2' ).select2( { width: 'resolve' } );
			}
		} catch (e) {
		}
	}

	// Mirror WP notices into toasts for quick feedback
	function efMirrorWpNoticesToToasts() {
		$( '.wrap.edgeframe-wrap .notice' ).each(
			function () {
				var $n = $( this );
				if ($n.data( 'efMirrored' )) {
					return;
				}
				$n.data( 'efMirrored', true );
				var text = $n.text().trim();
				if ( ! text) {
					return;
				}
				var type = 'success';
				if ($n.hasClass( 'notice-error' ) || $n.hasClass( 'error' )) {
					type = 'error';
				} else if ($n.hasClass( 'notice-warning' ) || $n.hasClass( 'warning' )) {
					type = 'warning';
				} else if (
				$n.hasClass( 'notice-info' ) ||
				$n.hasClass( 'info' ) ||
				$n.hasClass( 'updated notice-info' )
				) {
					type = 'info';
				}
				efToast( text, type );
			}
		);
	}

	$(
		function () {
			efInitTabs();
			efInitMedia();
			efInitColors();
			efBeautifyToggles();
			efInitRepeater();
			efInitRadioImage();
			efInitSearch();
			efEvaluateConditions( $( document ) );
			efBindConditionSources();
			efInitToastsFromQuery();
			efInitSelect2();
			efMirrorWpNoticesToToasts();

			// Let child themes hook JS
			$( document ).trigger( 'edgeframe:admin:ready', [window.EFAdmin || {}] );
		}
	);
})( jQuery );

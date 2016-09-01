$(".reg__mystery-number-form").on("focus", function () {
	if ($(this).val() === "" && $(this).attr("placeholder", "?")) 
	{
	$(this).removeAttr("placeholder");
	}
})

$(".reg__mystery-number-form").on("focusout", function() {
	if ($(this).val() === "" && !$(this).attr("placeholder", "?")){
		$(this).attr("placeholder", "?")
	}
})

 $(".reg__mystery-number-form").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(this).next('.reg__mystery-number-form').focus();
        }
  });

$(".ty__sm-icon").on("click", function() {
	setTimeout(function() {
self.location.href = "http://www.dubaiparksandresorts.com"
	}, 8000)
})

var scrollY = function (y) {
    console.log(y)
	if (window.jQuery) {
        FB.Canvas.getPageInfo (function (pageInfo) {
            $({ y: pageInfo.scrollTop })
                .animate({
                        y: y
                    },
                    {
                        duration: 1000,
                        step: function (offset) {
                            FB.Canvas.scrollTo(0, offset);
                    }
                });
        });
    } else {
        FB.Canvas.scrollTo(0, y);
    }
};

var mnTries = 0;


;(function(root, factory)	{

	// GIS = Get into Singapore
	window.GIS = window.GIS || factory;

})(this, (function() {

	/**
	 * Define framework object
	 *
	 * All methods, variables, values
	 * goes inside this object
	 */
	var framework = {
		version: '4.0.0',
		fbappid: '1746595485598828',
		max_recipients: 150,
		exclude_ids: []
	};


	/**
	 * Default methods call
	 */
	framework.init = function() {

		// Facebook object
		framework.facebook = new Socialmedia.Facebook({
			appid: framework.fbappid,
			callback: framework.fbCallbacks
		});

		// Twitter object
		framework.twitter = new Socialmedia.Twitter();

		// Google Plus object
		framework.gplus = new Socialmedia.GooglePlus();
	};


	/**
	 * Facebook callbacks
	 */
	framework.fbCallbacks = function(response) {


		// Setup get started user permissions
		framework.getUserPermissions(response);

		// Register form prefil
		framework.prefilRegisterForm(response);

		// Setup social sharing methods
		framework.enableSocialShare(response);

		// Setup quiz validation
		framework.quizValidation(response);

		// Invite friends via FB
		framework.inviteViaFacebook(response);

		// Invite friends via FB
		framework.inviteViaEmail(response);
	};


	/**
	 * Invite friends via Email
	 */
	framework.inviteViaEmail = function(response) {
		var inviteViaEmailBtn = $('#inviteViaEmail'),
			inviteBtns = $('#inviteBtns'),
			inviteViaEmailForm = $('#inviteViaEmailForm'),
			closeInviteViaEmailForm = $('#closeInviteViaEmailForm');

		if ( ! inviteViaEmailBtn.length ) return;

		inviteViaEmailBtn.on('click', function(e)	{
		
			if ( response && response.status === 'connected' ) {
				inviteBtns.hide();
				inviteViaEmailForm.slideDown();

				closeInviteViaEmailForm.on('click', function(e)	{
					inviteBtns.fadeIn();
					inviteViaEmailForm.slideUp();
					e.preventDefault();
				});

				framework.validateInviteViaEmailForm( $('#inviteFriendSubmit') );
			}
			else {
				framework.fbLogin(function(response)	{
					if ( response && response.status === 'connected' ) {
						FB.api('/me', function(info)	{
							self.location.href = 'register.php?fbid=' + info.id;
						});
					}
				});
			}

			e.preventDefault();
		});
	};


	/**
	 * Validate invite via email form
	 */
	framework.validateInviteViaEmailForm = function(submit)	{
		var howMany = 0;
		submit.on('click', function(e)	{


			var formFields = {
				friendEmails: [],
				request: 'inviteViaEmail',
				appCabachaField: $('#appCabachaField').val(),
				cabachaField: $('#cabachaField').val(),
				uidField: $('#uidField').val()
			};

			var usedFields = [];

			$('.friend-email').each(function(i, el)	{
				if ( $(el).val().length > 0 ) {
					if ( $.inArray($(el).val(), formFields.friendEmails) === -1 ) {
						formFields.friendEmails.push( $(el).val() );
						usedFields.push($(el).parents('.form-group'));
					}
				}
			});

			if ( formFields.friendEmails.length ) {
				$.ajax({
					url: './template/InviteByEmailModel.php',
					data: formFields,
					type: 'post',
					success: function(data) {
						if ( data && !data.error ) {
							if ( data.code && data.code === 201 ) {
								if ( usedFields.length ) {
									for (var i = 0; i < usedFields.length; i++)	{
										usedFields[i].delay(100 * i).slideUp().delay(200).promise().done(function()	{
											$(this).remove();
										});
									}

									howMany += usedFields.length;

									if ( howMany === 3 )
										self.location.href = 'scratch.php?uid=' + formFields.uidField;
								}
								else {
									console.log('Unknown error occured.');
									self.location.href = 'scratch.php?uid=' + formFields.uidField;
								}
							}
						}
						else {
							if ( data.error && data.error.code ) {
								if ( data.error.code === 422 ) {
									alert(data.error.message);
								}
							}
						}
					},
					error: function(xhr, error) {
						// console.log(error);
					}
				});
			}
			else {
				alert('Please enter at least one email to invite a friend.');
			}
		});
	};


	/**
	 * Invite friends via Facebook
	 */
	framework.inviteViaFacebook = function(response) {
		var inviteViaFacebookBtn = $('#inviteViaFacebook');
		if ( ! inviteViaFacebookBtn.length ) return;

		$.ajax({
			url: './template/InviteByFacebookModel.php',
			data: {
				uid: inviteViaFacebookBtn.data('uid'),
				request: 'getInvitedFriends'
			},
			type: 'post',
			success: function(data) {
				if (data && !data.error) {
					if (data.code && data.code === 200 && data.data) {
						if (data.data.fb) {
							framework.exclude_ids = data.data.fb;
						}
						else {
							framework.exclude_ids = [];
						}
					}
				}
			},
			error: function(xhr, error) {
				console.log(error);
			}
		});

		inviteViaFacebookBtn.on('click', function(e)	{
			if ( response && response.status === 'connected' ) {
				FB.api('/me', function(info)	{
					return framework.inviteFbFriends( inviteViaFacebookBtn, info );
				});
			}
			else {
				framework.fbLogin(function(response)	{
					if ( response && response.status === 'connected' ) {
						FB.api('/me', function(info)	{
							self.location.href = 'register.php?fbid=' + info.id;
						});
					}
				});
			}
		});
	};


	/**
	 * Invite Facebook friends
	 */
	framework.inviteFbFriends = function( control, info ) {
		// FB.ui({mehod:'apprequest'})
		// return;

		framework.facebook.Invite({
			title: control.data('title'),
			message: control.data('message'),
			// max_recipients: framework.max_recipients,
			exclude_ids: framework.exclude_ids,
			callback: function(response) {
				if ( response && response.request ) {
					var currentExcludeIds = framework.exclude_ids;
					var updatedExcludeIds = currentExcludeIds.concat(response.to);
					framework.exclude_ids = updatedExcludeIds;

					// var currentMaxRecipients = framework.max_recipients;
					// var updatedMaxRecipients = (currentMaxRecipients - response.to.length);
					// framework.max_recipients = updatedMaxRecipients;

					$.ajax({
						url: './template/InviteByFacebookModel.php',
						data: {
							fbid: info.id,
							uid: control.data('uid'),
							invites: response,
							request: 'inviteFbFriends'
						},
						type: 'post',
						success: function(data) {
							if (data && !data.error) {
								if ( data.code && data.code === 201 ) {
									self.location.href = 'scratch.php?uid=' + control.data('uid')
									// if ( framework.max_recipients === 0 ) {
									// }
								}
							}
						},
						error: function(xhr, error) {
							// console.log(error);
						}
					});
				}
			}
		});
	};


	/**
	 * Setup quiz validation
	 */
	framework.quizValidation = function(response)	{
		var gisAnswers = $('.gis-answers'),
			answers = $('.gis-answers li'),
			uid = gisAnswers.data('uid'),
			qid = gisAnswers.data('qid');

		if ( ! gisAnswers.length ) return;

		answers.each(function(el, i)	{
			var $this = $(this);

			$this.on('click', function(e)	{
				var ans = $this.data('ca');
				$('.quiz-notice').remove();
				return framework.quizRedirect(ans, uid, qid);
			});
		});

		$('#quizVideoShare').on('click', function(e)	{
			var $this = $(this),
				$title = $this.data('title'),
				$link = $this.data('link'),
				$caption = $this.data('caption'),
				$picture = $this.data('picture'),
				$description = $this.data('description');

			$source = $link.replace('/embed/', '/v/');
			$link = $link.replace('/embed/', '/watch?v=');

			FB.ui({
				method: 'share',
				name: $title,
				href: $link,
				caption: $caption,
				description: $description
			}, function(response)	{
				if ( response && !response.error )
					ga('send', 'event', 'VideoShare', $title);
			});

			// framework.facebook.Share({
			// 	name: $title,
			// 	source: $source,
			// 	link: $link,
			// 	caption: $caption,
			// 	picture: $picture,
			// 	description: $description,
			// 	callback: function(response) {
			// 		if ( response && !response.error )
			// 			ga('send', 'event', 'VideoShare', $title);
			// 	}
			// });

			e.preventDefault();
		});

	};


	/**
	 * Quiz redirection according to answer chosen
	 */
	framework.quizRedirect = function(ans, uid, qid) {
		var nextQuizBtn = $('.next-quiz-btn').hide(),
			quizNotice = $('<p />', {
				'class': 'quiz-notice',
				'html': ''
			}).insertAfter( $('.gis-answers') ).hide();

		if ( ans === 'y' ) {
			quizNotice.html('<i class="fa fa-check"></i> Correct answer!')
				.addClass('text-success')
				.fadeIn();
			nextQuizBtn.fadeIn();
		}
		else {
			quizNotice.html('<i class="fa fa-times"></i> Wrong answer, please try again!')
				.addClass('text-danger')
				.fadeIn().delay(2000).promise().done(function()	{
					$(this).fadeOut();
				});
		}

	};



	/**
	 * Enable social share methods
	 */
	framework.enableSocialShare = function(response) {
		var fbShareBtn = $('.ss-facebook'),
			twttrShareBtn = $('.ss-twitter'),
			gplusShareBtn = $('.ss-gplus');

		if ( ! fbShareBtn.length ) return;

		// Facebook Share
		fbShareBtn.on('click', function(e)	{
			var $this = $(this),
				$title = $this.data('title'),
				$link = $this.data('link'),
				$picture = $this.data('picture'),
				$caption = $this.data('caption'),
				$description = $this.data('description');

			framework.facebook.Feed({
				name: $title,
				link: $link,
				picture: $picture,
				caption: $caption,
				description: $description
			});

			e.preventDefault();
		});


		// Google Plus Share
		gplusShareBtn.on('click', function(e)	{
			var $this = $(this),
				$link = $this.data('link');

			framework.gplus.Share({
				link: $link
			});

			e.preventDefault();
		});

	};



	/**
	 * Setup get started user permissions
	 */
	framework.getUserPermissions = function(response) {

		var getStartedBtn = $('.tab__fb-login');

		if ( ! getStartedBtn.length ) return;

		getStartedBtn.on('click', function(e)	{
			var $this = $(this);

			if ( response && response.status === 'connected' ) {
				FB.api('/me', function(info)	{
					return self.location.href = 'register.php?fbid=' + info.id
				});
			}
			else {
				framework.fbLogin(function(response)	{
					if ( response && response.status === 'connected' ) {
						FB.api('/me', function(info)	{
							return self.location.href = 'register.php?fbid=' + info.id
						});
					}
				});
			}

			return e.preventDefault();
		});

	};



	/**
	 * Register form prefil
	 */
	framework.prefilRegisterForm = function(response) {

		if ( ! $('[id=registerForm]').length ) return;
		if ( response && response.status === 'connected' ) {
			var formFields = {
				firstNameField: $('[id=firstNameField]'),
				lastNameField: $('[id=lastNameField]'),
				emailField: $('[id=emailField]'),
				phoneField: $('[id=phoneField]'),
				fbidField: $('[id=fbidField]'),
				num1: $('[id=num1]'),
				num2: $('[id=num2]'),
				num3: $('[id=num3]'),
				num4: $('[id=num4]'),
				num5: $('[id=num5]'),
				num6: $('[id=num6]'),
				submitBtn: $('[id=reg__submitBtn]')
			};

			FB.api('/me?fields=first_name,last_name,email', function(info)	{
				formFields.firstNameField.val( info.first_name );
				formFields.lastNameField.val( info.last_name );
				formFields.emailField.val( info.email );
				formFields.fbidField.val( info.id );
			});

			return framework.validateRegisterForm(formFields);
		}
		else {
			framework.fbLogin(function(response)	{
				if ( response && response.status === 'connected' ) {
					return framework.prefilRegisterForm(response);
				}
				else {
					self.location.href = 'tab.php?auth=0'
				}
			});
		}
	};


	/**
	 * FB Login helper method
	 */
	framework.fbLogin = function(callback)	{
		return FB.login(callback,	{
			scope: 'email'
		});
	};



	/**
	 * Register form validation
	 */



	framework.validateRegisterForm = function(formFields)	{
		formFields.submitBtn.on('click', function(e)	{
			var numbers = {
				1: formFields.num1.val(),
				2: formFields.num2.val(),
				3: formFields.num3.val(),
				4: formFields.num4.val(),
				5: formFields.num5.val(),
				6: formFields.num6.val()				
			}
			
			var combinedNumbers = numbers[1].concat(numbers[2], numbers[3], numbers[4], numbers[5], numbers[6]);
			
			if ( formFields.firstNameField.val() == '' ) {
				alert('Bitte trage Deinen Vornamen ein');
				formFields.firstNameField.focus();
			}
			else if ( formFields.firstNameField.val().length > 100 ) {
				alert('Der Vorname ist ungültig');
				formFields.firstNameField.focus();
			}
			else if ( formFields.lastNameField.val() == '' ) {
				alert('Bitte trage Deinen Nachnamen ein');
				formFields.lastNameField.focus();
			}
			else if ( formFields.lastNameField.val().length > 100 ) {
				alert('Der Nachname ist ungültig');
				formFields.lastNameField.focus();
			}
			else if ( formFields.emailField.val() == '' ) {
				alert('Bitte trage Deine Email-Adresse ein');
				formFields.emailField.focus();
			}
			else if ( ! framework.isValidEmail(formFields.emailField.val()) || (formFields.emailField.val().length > 255) ) {
				alert('Bitte trage eine gültige Email-Adresse ein');
				formFields.emailField.focus();
			}
			/*else if( ((formFields.phoneField.val() !== '') && ( formFields.phoneField.val().length > 15 || isNaN(formFields.phoneField.val()) )) || formFields.phoneField.val() == formFields.phoneField.attr('placeholder') )	{
							alert('Phone number is not valid.');
							formFields.phoneField.focus();
							formFields.phoneField.select();
						}*/
			 else if (combinedNumbers.length != 0 && combinedNumbers.length != 6) {
			 	alert ("Bitte den vollständigen Code eintragen um fortzufahren")
			 }			
			
			else if (combinedNumbers.length != 0 && (!$.isNumeric(numbers[1]) || !$.isNumeric(numbers[2]) || !$.isNumeric(numbers[3]) || !$.isNumeric(numbers[4]) || !$.isNumeric(numbers[5]) || !$.isNumeric(numbers[6])))
			 {
				alert ("Bitte nur Nummern eingeben")
			}
			else if (combinedNumbers.length == 6 && combinedNumbers !== "311016" && mnTries < 3) {
				mnTries ++;
				if (mnTries >= 3) {
					return true
				} else {
				alert ("Sorry, Ihr Code ist falsch. Versuch es noch einmal!");
				}

			}
			else if (combinedNumbers == "311016") {
				scrollY(0);
				setTimeout(function(){
					self.location.href = "./thank-you.php"
				}, 1000);
			}

			
 			else {
				return true;
			}
			return e.preventDefault();
		});

		var unlikeWarning = $('.reg__unlike-warning');
		if ( unlikeWarning.length ) {
			FB.Event.subscribe('edge.remove', function(url, el)	{
				unlikeWarning.fadeIn();
			});

			FB.Event.subscribe('edge.create', function(url, el)	{
				if ( ! unlikeWarning.is(':hidden') ){
					unlikeWarning.fadeOut();}
			});
		}
	};


	/**
	 * Email validation
	 */
	framework.isValidEmail = function(email) {
		if ( typeof email !== 'string' || email === '' )
			return false;

		var has_at = new RegExp(/@/);
		var has_dot = new RegExp(/\./);
		var dot_at_end = new RegExp(/\./);

		return ( has_at.test(email) && has_dot.test(email) && ! dot_at_end.test(email.substr(email.length - 1)) );
	};
	/**
	 * Return all methods as single object
	 */
	return framework;

})());

/**
 * Initiate all default methods
 */
$(document).ready(function()	{
	GIS.init();
});


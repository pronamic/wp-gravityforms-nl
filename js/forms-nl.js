// Form
if(typeof Form == "function") {
	var OriginalForm = Form;
	Form = function() {
		var form = new OriginalForm();
		form.title = gravityFormsNlL10n.formTitle;
		form.description = gravityFormsNlL10n.formDescription;
		
		return form;
	}
}

// Confirmation
if(typeof Confirmation == "function") {
	var OriginalConfirmation = Confirmation;
	Confirmation = function() {
		var confirmation = new OriginalConfirmation();
		confirmation.message = gravityFormsNlL10n.confirmationMessage;
		
		return confirmation;
	}
}

// Button
if(typeof Button == "function") {
	var OriginalButton = Button;
	Button = function() {
		var button = new OriginalButton();
		button.text = gravityFormsNlL10n.buttonText;
		
		return button;
	}
}
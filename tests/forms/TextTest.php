<?hh

namespace beatbox\test;

use beatbox;

class TextFieldTest extends beatbox\Test {
	/**
	 * @group sanity
	 */
	public function testMaxlengthValidation() {
		$field = <bb:form:text maxlength="5" />;
		$field->setValue('Ω≈ç√∫µ');

		$this->assertFalse($field->validate()[0]);

		$field->setValue('œ∑´®ƒ');

		$errors = $field->validate();
		$this->assertTrue($errors[0], $errors[1]);
	}

	public function testPatternValidation() {
		$field = <bb:form:text />;

		$field->setAttribute('pattern', '\w@\w{2}\.\w{3}');
		$field->setValue('hello@pass.com');
		$this->assertFalse($field->validate()[0]);

		$field->setValue('a@bc.def');
		$errors = $field->validate();
		$this->assertTrue($errors[0], $errors[1]);
	}

	public function testRequiredValidation() {
		$field = <bb:form:text />;

		$field->setAttribute('required', true);
		$field->setValue(null);
		$this->assertFalse($field->validate()[0]);

		$field->setValue('hello@pass.com');
		$errors = $field->validate();
		$this->assertTrue($errors[0], $errors[1]);

		$field->setAttribute('required', false);
	}

	/**
	 * @group sanity
	 */
	public function testEmptyValidation() {
		$field = <bb:form:text maxlength="2" pattern="\w+" />;
		$field->setValue(null);

		$errors = $field->validate();
		$this->assertTrue($errors[0], $errors[1]);

		$field->setValue('');

		$errors = $field->validate();
		$this->assertTrue($errors[0], $errors[1]);
	}
}

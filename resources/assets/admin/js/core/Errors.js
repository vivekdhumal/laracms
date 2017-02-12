/**
* this class will represent form validation errors
*/
class Errors {

	/**
	* assign an empty object to errors
	*/
	constructor() {
		this.errors  = {};
	}

	/**
	* get the error message from array offset 0 of specified field name
	*
	* @param field - string
	* @return error message - string
	*/
	get(field) {
		if(this.errors[field]) {
			return this.errors[field][0];
		}
	}

	/**
	* checking if errors array has the specified field name
	*
	* @param field - string
	* @return boolean
	*/
	has(field) {
		return this.errors.hasOwnProperty(field);
	}

	/**
	* checking if errors array is non empty
	*
	* @return boolean
	*/
	any() {
		return Object.keys(this.errors).length > 0;
	}

	/**
	* setting the validation errors
	*
	* @param errors - string array object
	*/
	set(errors) {
		this.errors = errors
	}

	/**
	* Clearing the validation errors
	*
	* @param field - string
	*/
	clear(field) {
		if(field) {			
			delete this.errors[field];

			return;
		}

		this.errors = {};
	}
}

export default Errors;
import Errors from './Errors';
/**
* This class will represent a form and its actions
*/
class Form {

	/**
	* Bind all form field/prameters to this class instance
	*
	* @param data - array object
	*/
	constructor(data) {
		this.originalData = data;

		for(let field in data) {

			this[field] = data[field];

		}

		this.errors = new Errors();
	}	

	/**
	* Bind all form field/prameters to this class instance
	*
	* @param data - array object
	*/
	data() {
		let data = {};

		for(let property in this.originalData) {

			data[property] = this[property];

		}

		return data;
	}

	/**
	* Submit POST request
	*
	* @param url - string
	*/
	post(url) {
		return this.submit('post', url);
	}

	/**
	* Submit PUT request
	*
	* @param url - string
	*/
	put(url) {
		return this.submit('put', url);
	}

	/**
	* Submit PATCH request
	*
	* @param url - string
	*/
	patch(url) {
		return this.submit('patch', url);
	}

	/**
	* Submit DELETE request
	*
	* @param url - string
	*/
	delete(url) {
		return this.submit('delete', url);
	}

	/**
	* Submiting ajax request
	*
	* @param requestType (POST/PUT/PATCH) - string
	* @param url - string
	*/
	submit(requestType, url) {
		return new Promise((resolve, reject) => {
				axios[requestType](url, this.data())
				.then(response => {

					resolve(response.data);

				})
				.catch(error => {

					this.onFail(error.response.data);

					reject(error.response.data);

				});
			});
	}

	/**
	* Reset the form fields
	*/
	reset() {
		for(let field in this.originalData) {
			this[field] = '';
		}

		this.errors.clear();
	}

	/**
	* On form submition success reset the form
	*/
	onSuccess(data) {
		this.reset();
	}

	/**
	* On form submition failed set the error messages
	*/
	onFail(error) {
		this.errors.set(error);
	}
}

export default Form
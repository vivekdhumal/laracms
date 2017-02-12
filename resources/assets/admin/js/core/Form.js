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
		/*delete data.originalData;
		delete data.errors;*/

		console.log(data);

		return data;
	}

	submit(requestType, url) {
		return new Promise((resolve, reject) => {
				axios[requestType](url, this.data())
				.then(response => {
					//this.onSuccess(response.data);

					resolve(response.data);
				})
				.catch(error => {
					this.onFail(error.response.data);

					reject(error.response.data);
				});
			});
	}

	reset() {
		for(let field in this.originalData) {
			this[field] = '';
		}

		this.errors.clear();
	}

	onSuccess(data) {
		this.reset();
	}

	onFail(error) {
		this.errors.set(error);
	}
}

export default Form
class Category {

	static all() {
		return axios.get("/admin/categories");
	}

	static withoutPagination() {
		return axios.get("/admin/categories/all");
	}

	static delete(id) {
		return axios.delete("/admin/categories/"+id);
	}
}

export default Category;
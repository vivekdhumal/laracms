class Category {

	static all() {
		return axios.get("/admin/blog-categories");
	}

	static withoutPagination() {
		return axios.get("/admin/blog-categories/all");
	}

	static delete(id) {
		return axios.delete("/admin/blog-categories/"+id);
	}
}

export default Category;
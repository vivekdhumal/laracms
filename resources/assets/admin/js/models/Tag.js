class Tag {

	static all() {
		return axios.get("/admin/tags");
	}

	static withoutPagination() {
		return axios.get("/admin/tags/all");
	}

	static delete(id) {
		return axios.delete("/admin/tags/"+id);
	}
}

export default Tag;
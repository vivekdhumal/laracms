class Tag {

	static all() {
		return axios.get("/admin/blog-tags");
	}

	static delete(id) {
		return axios.delete("/admin/blog-tags/"+id);
	}
}

export default Tag;
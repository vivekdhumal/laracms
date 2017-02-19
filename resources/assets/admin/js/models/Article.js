class Article {

	static all() {
		return axios.get("/admin/blog-articles");
	}

	static edit(id) {
		return axios.get("/admin/blog-articles/"+id+"/edit");
	}

	static delete(id) {
		return axios.delete("/admin/blog-articles/"+id);
	}
}

export default Article;
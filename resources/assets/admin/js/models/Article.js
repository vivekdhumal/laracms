class Article {

	static all() {
		return axios.get("/admin/articles");
	}

	static edit(id) {
		return axios.get("/admin/articles/"+id+"/edit");
	}

	static delete(id) {
		return axios.delete("/admin/articles/"+id);
	}
}

export default Article;
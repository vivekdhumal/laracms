class User {

	static all() {
		return axios.get("/admin/blog-users");
	}

	static edit(id) {
		return axios.get("/admin/blog-users/"+id+"/edit");
	}

	static delete(id) {
		return axios.delete("/admin/blog-users/"+id);
	}
}

export default User;
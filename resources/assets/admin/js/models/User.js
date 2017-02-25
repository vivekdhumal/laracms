class User {

	static all() {
		return axios.get("/admin/users");
	}

	static edit(id) {
		return axios.get("/admin/users/"+id+"/edit");
	}

	static delete(id) {
		return axios.delete("/admin/users/"+id);
	}
}

export default User;
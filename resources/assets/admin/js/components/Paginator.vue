<template>	
	<ul class="pagination" v-if="resultSet.total && resultSet.total > 0">
		<li :class="{ 'disabled': prevPageUrl == null }">
			<a href="javascript:;" @click="goToPage(1)">&lt;&lt;</a>
		</li>
		<li :class="{ 'disabled': prevPageUrl == null }">
			<a href="javascript:;" @click="paginatePrevData()">&lt;</a>
		</li>
		<li v-for="page in resultSet.last_page" :class="{ 'active': page == resultSet.current_page }">
			<a href="javascript:;" @click="goToPage(page)">{{ page }}</a>
		</li>
		<li :class="{ 'disabled': nextPageUrl == null }">
			<a href="javascript:;" @click="paginateNextData()">&gt;</a>
		</li>
		<li :class="{ 'disabled': nextPageUrl == null }">
			<a href="javascript:;" @click="goToPage(resultSet.last_page)">&gt;&gt;</a>
		</li>
	</ul>
</template>

<script>
	export default {
		props: [
			'nextPageUrl',
			'prevPageUrl',
			'resultSet',
			'paginationBaseUrl'
		],

		created() {
			console.log(this.nextPageUrl);
		},

		methods: {
			goToPage(page) {
				this.changePage(this.paginationBaseUrl+"?page="+page);
			},

			paginateNextData() {
				this.changePage(this.nextPageUrl);
			},

			paginatePrevData() {
				this.changePage(this.prevPageUrl);
			},

			changePage(url) {
				axios.get(url)
				.then(response => {
					Event.fire('onPageChanged', response.data);
				})
				.catch(error => {
					//console.log(error.response.data);
				});
			}
		}
	}
</script>
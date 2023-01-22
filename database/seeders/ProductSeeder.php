<?php /** @noinspection SpellCheckingInspection */

namespace Database\Seeders;

use App\Enums\SubtractStock;
use App\Models\Product;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder {
	/**
	 * @throws Exception
	 */
	final public function run(): void {
		$productData = [];
		$timestamp = Carbon::now()->toDateTimeString();

		for ($index = 0; $index < 150; $index++) {
			$productData[] = [
				"name" => "Product - $index",
				"slug" => Str::snake("Product - $index"),
				"description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto assumenda distinctio ducimus eaque eveniet harum in iure mollitia natus, nostrum perspiciatis qui quod repellendus sapiente soluta tenetur totam ullam. Amet beatae doloremque ipsum laborum magnam modi molestias non praesentium quaerat, quasi! Alias architecto, consectetur deserunt dignissimos distinctio eaque error, hic, iure laboriosam magni nisi quod repellat sint. Animi at, cupiditate ducimus eum facere illum laudantium, maxime minus, molestiae nostrum numquam perspiciatis qui sapiente tempore ut veniam vitae. Ab laboriosam perferendis recusandae voluptate voluptatem? Atque eius facere numquam perspiciatis quaerat quas reprehenderit, sed sit! Amet architecto esse magni molestiae rerum? Ab consectetur distinctio dolores eum exercitationem obcaecati placeat quod rem soluta, velit! Accusamus animi at consectetur dolore dolorum eveniet id ipsa mollitia, praesentium provident reprehenderit sequi ut veniam? Ab adipisci atque commodi cum distinctio dolor doloribus eius fugiat fugit incidunt labore, natus nemo nisi officiis optio perspiciatis quia quod saepe sed tempora tempore temporibus vitae voluptates. Beatae corporis eius et exercitationem id magni nesciunt quaerat qui, quisquam. Accusantium atque eum ex exercitationem fuga fugiat fugit nisi quis? A accusamus adipisci asperiores assumenda at atque blanditiis consectetur consequatur corporis debitis deserunt distinctio esse eum ex excepturi facere fuga id ipsum, magni maiores modi non nulla odio odit pariatur quae quam, quod rem saepe sed soluta unde vel velit veniam vitae voluptas voluptatem. Cumque dolor inventore placeat saepe similique? Amet aperiam architecto aspernatur beatae cupiditate, dolor dolorem ducimus ex facere facilis fugit in molestias pariatur perferendis praesentium quam quibusdam rerum sapiente sed ullam!",
				"meta_title" => "SEO",
				"meta_description" => "SEO",
				"meta_keywords" => "SEO",
				"sku" => Str::uuid(),
				"upc" => Str::uuid(),
				"price" => random_int(50, 2500),
				"quantity" => random_int(0, 50),
				"image" => null,
				"min_order_quantity" => random_int(1, 3),
				"subtract_stock" => $index % 4 === 0 ? SubtractStock::NO->value : SubtractStock::YES->value,
				"require_shipping" => $index % 9 === 0 ? SubtractStock::NO->value : SubtractStock::YES->value,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		Product::insert($productData);
	}
}

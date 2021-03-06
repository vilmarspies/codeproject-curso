<?php
namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class MemberTransformer extends TransformerAbstract
{


	public function transform(User $member)
	{
		return [
			'id' => $member->pivot->id,
			'member_id' => $member->id,
			'name' => $member->name,
		];
	}
}
<?php

namespace Weile\Repositories;

use Weile\Member;

interface MemberRepositoryInterface
{
    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\Paginator|\User[]
     */
    public function findAllPaginated($perPage = 200);

    /**
     * Find a user by it's username.
     *
     * @param  string $username
     * @return \Tricks\User
     */
    public function findByUsername($username);

    /**
     * Find a user by it's email.
     *
     * @param  string $email
     * @return \Tricks\User
     */
    public function findByEmail($email);


    /**
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return \Tricks\User
     */
    public function create(array $data);



    /**
     * Update the user's settings.
     *
     * @param  array $data
     * @return \Tricks\User
     */
    public function updateSettings(Member $memeber, array $data);
}

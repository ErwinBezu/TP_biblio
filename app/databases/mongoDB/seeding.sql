use LibraryLogs

db.reviews.insertMany([
  {
    rating: 5,
    comment: "Excellent book, gripping story.",
    read_date: ISODate("2024-05-12T10:00:00Z"),
    user_id: ObjectId("5"),
    book_id: ObjectId("4")
  },
  {
    rating: 3,
    comment: "Good content but a bit slow at the start.",
    read_date: ISODate("2024-06-01T14:30:00Z"),
    user_id: ObjectId("3"),
    book_id: ObjectId("1")
  },
  {
    rating: 4,
    comment: "Very good technical book.",
    read_date: ISODate("2024-06-10T09:15:00Z"),
    user_id: ObjectId("1"),
    book_id: ObjectId("2")
  }
])


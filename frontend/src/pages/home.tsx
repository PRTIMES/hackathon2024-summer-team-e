import { Box, Container, Typography, Button } from '@mui/material'
import type { NextPage } from 'next'
import { useState, useEffect } from 'react'
import ArticleCard from '@/components/ArticleCard'
import Error from '@/components/Error'
import Loading from '@/components/Loading'

type ArticleProps = {
  id: number
  title: string
  content: string
  url: string
}

const Index: NextPage = () => {
  const [articles, setArticles] = useState<ArticleProps[]>([])
  const [loading, setLoading] = useState<boolean>(true)
  const [error, setError] = useState<boolean>(false)
  const [itemsToShow, setItemsToShow] = useState<number>(30)

  useEffect(() => {
    fetch('https://jsonplaceholder.typicode.com/photos')
      .then((response) => {
        if (!response.ok) {
          return;
        }
        return response.json()
      })
      .then((data) => {
        setArticles(data)
        setLoading(false)
      })
      .catch((error) => {
        console.error('Error fetching data:', error)
        setError(true)
        setLoading(false)
      })
  }, [])

  const handleLoadMore = () => {
    setItemsToShow(itemsToShow + 30)
  }

  if (loading) return <Loading />
  if (error) return <Error />

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2, color: 'text.primary' }}
      >
        オススメ記事
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4, color: 'text.primary' }}
      >
        あなたが気になる記事を選ぼう
      </Typography>
      <Container maxWidth="md">
        {articles.slice(0, itemsToShow).map((article) => (
          <Box key={article.id} sx={{ mb: 4, bgcolor: 'white' }}>
            <ArticleCard {...article} />
          </Box>
        ))}
        {itemsToShow < articles.length && (
          <Box sx={{ textAlign: 'center', mt: 4 }}>
            <Button variant="contained" onClick={handleLoadMore}>
              もっと見る
            </Button>
          </Box>
        )}
      </Container>
    </Box>
  )
}

export default Index
